const baseApiUrl = 'http://localhost:8000/';

$(document).ready(async function() {
    $.ajaxSetup({
        dataType: 'json',
    });

    if(! await apiStatusOk() || ! await migrationStatusOk()) {
        return false;
    }

    bootstrap();
});

const loadContent = (type, callback) => {
    const pages = {
        'login'        : $('#login-template').html(),
        'hello-world'  : $('#hello-world-template').html(),
        'migration'    : $('#migration-template').html(),
        'api-off'      : $('#api-off-template').html(),
        'database-off' : $('#database-off-template').html(),
    }

    $('#page-content').html( pages[ type ] || '404 - Página não encontrada' );

    if( typeof callback === 'function' ) {
        callback();
    }
}

const bootstrap = () => {
    const accessToken = localStorage.getItem('access_token');

    if(accessToken) {
        loadContent('hello-world', () => loadApiContent());

        $('#user-id').html( localStorage.getItem('access_id') );
        $('#user-email').html( localStorage.getItem( 'access_email' ) );
    }
    else {
        loadContent('login');
    }

    setLoginFormSubmit();
    setLogoutButtonClick();
}

const apiStatusOk = async () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseApiUrl + 'status',
            type: 'GET',
            success: function(data) {
                if(data?.OK) {
                    resolve(true);
                }

                loadContent('api-off');
                reject(false);
            },
            error: function (error) {
                console.log(error?.responseJSON?.code)
                if( error?.responseJSON?.code === 'DATABASE_NOT_CONNECTING' ) {
                    loadContent('database-off');
                } else {
                    loadContent('api-off');
                }

                reject(false);
            }
        });
    });
}

const migrationStatusOk = async () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseApiUrl + 'migration-status',
            type: 'GET',
            success: function(data) {
                if(data?.OK) {
                    resolve(true);
                }

                $('#page-content').on('click', '#migration-button', async function(event) {
                    event.preventDefault();

                    if( await runMigration() ){
                        bootstrap();
                        loadContent('login');
                    }

                    return false;
                });

                loadContent('migration');

                reject(false);
            },
            error: function (error) {
                if( error?.responseJSON?.code === 'DATABASE_NOT_CONNECTING' ) {
                    loadContent('database-off');

                } else {
                    loadContent('api-off');
                }

                reject(false);
            }
        });
    });
}

const runMigration = async () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseApiUrl + 'migrate',
            type: 'GET',
            beforeSend: () => {
                $('#migration-button-message').addClass('visually-hidden');
                $('#migration-button-spin').removeClass('visually-hidden');
                $('#migration-button-loading').removeClass('visually-hidden');
            },
            success: function (data) {
                if (data?.OK) {
                    $('#migration-button').remove();
                    resolve(true);
                }

                $('#migration-button').removeClass('visually-hidden');
                $('#migration-button-spin').addClass('visually-hidden');
                $('#migration-button-loading').addClass('visually-hidden');

                $('#migration-errors').html(JSON.stringify(data));
                reject(false);
            },
            error: function (error) {
                $('#migration-button').removeClass('visually-hidden');
                $('#migration-button-spin').addClass('visually-hidden');
                $('#migration-button-loading').addClass('visually-hidden');

                $('#migration-errors').html(JSON.stringify(data));
                reject(false);
            },
        });
    });
}

const loadApiContent = () => {
    $.ajax({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
        },
        url: baseApiUrl,
        type: 'GET',
        success: function (data) {
            $('#api-loggedin-title').html( data.title );
            $('#api-loggedin-message').html( data.message );
        },
        error: function (error) {
            console.error(error);
            alert('OOps! Erro ao carregar os dados de rota protegida da API');
        },
    });
}

const setLoginFormSubmit = () => {
    $('#page-content').on('submit', '#login-form', function(event) {
        event.preventDefault();

        const username = $('#email').val();
        const password = $('#password').val();

        $.ajax({
            url: baseApiUrl + 'login',
            type: 'POST',

            data: { username, password },
            success: function(data) {
                $('#login-errors').addClass('visually-hidden');

                localStorage.setItem('access_id',    data.id);
                localStorage.setItem('access_email', data.email);
                localStorage.setItem('access_token', data.token);

                loadContent('hello-world', () => loadApiContent());

                $('#user-id').html( data.id );
                $('#user-email').html( data.email );
            },
            error: function (error) {
                $('#login-errors').removeClass('visually-hidden');
                $('#login-errors').html( error.responseJSON.reason_phrase );
            }
        });

        return false;
    });
}

const setLogoutButtonClick = () => {
    $('#page-content').on('click', '#logout-button', function(event) {
        event.preventDefault();

        localStorage.removeItem('access_id');
        localStorage.removeItem('access_email');
        localStorage.removeItem('access_token');

        loadContent('login');

        return false;
    });
}