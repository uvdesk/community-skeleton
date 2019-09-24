{% extends 'base.html.twig' %}

{% block title %}Log in!{% endblock %}

{% block body %}
<form method="post">
    {% if error %}
        <div class="alert alert-danger">{{ error.messageKey|trans(error.messageData, 'security') }}</div>
    {% endif %}

<?php if ($logout_setup): ?>
    {% if app.user %}
        <div class="mb-3">
            You are logged in as {{ app.user.username }}, <a href="{{ path('app_logout') }}">Logout</a>
        </div>
    {% endif %}
<?php endif; ?>

    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="input<?= ucfirst($username_field); ?>" class="sr-only"><?= $username_label; ?></label>
    <input type="<?= $username_is_email ? 'email' : 'text'; ?>" value="{{ last_username }}" name="<?= $username_field; ?>" id="input<?= ucfirst($username_field); ?>" class="form-control" placeholder="<?= $username_label; ?>" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

    <input type="hidden" name="_csrf_token"
           value="{{ csrf_token('authenticate') }}"
    >

    {#
        Uncomment this section and add a remember_me option below your firewall to activate remember me functionality.
        See https://symfony.com/doc/current/security/remember_me.html

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="_remember_me"> Remember me
            </label>
        </div>
    #}

    <button class="btn btn-lg btn-primary" type="submit">
        Sign in
    </button>
</form>
{% endblock %}
