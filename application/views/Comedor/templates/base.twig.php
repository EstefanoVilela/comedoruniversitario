<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <!-- Para que funcione el responsive -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ title }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">


    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body onload="pintar('{{ flg|raw }}')">
    {% block content %}
    {% endblock %}

    {% include "Comedor/partials/modal.twig.php" %}

    <!-- jQuery -->
    <script src="assets/js/bootstrap/jquery-3.4.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="assets/js/resources/icons.js"></script>

    <!-- Our Custom CSS -->
    <script src="assets/js/resources/resources.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>