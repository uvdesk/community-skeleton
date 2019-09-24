<?= $helper->getHeadPrintCode("Hello $class_name!"); ?>

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    <h1>Hello {{ controller_name }}! ✅</h1>

    This friendly message is coming from:
    <ul>
        <li>Your controller at <code><?= $helper->getFileLink("$root_directory/$controller_path", "$controller_path"); ?></code></li>
        <li>Your template at <code><?= $helper->getFileLink("$root_directory/$relative_path", "$relative_path"); ?></code></li>
    </ul>
</div>
{% endblock %}
