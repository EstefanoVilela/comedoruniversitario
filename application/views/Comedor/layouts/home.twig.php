{% extends "Comedor/templates/base.twig.php" %}

{% block content %}
    <!-- Page Content  -->
    <div id="content" class="tab-content" id="myTabContent">
        {% include "Comedor/partials/navbar.twig.php" %}
        
        <div class="container pt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            {% include "Comedor/layouts/reserva.php" %}
        </div>
        <div class="container pt-4 tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            {% include "Comedor/layouts/historial.twig.php" %}
        </div>
        <div class="container pt-4 tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
            {% include "Comedor/layouts/menu.twig.php" %}
        </div>
        <div class="container pt-4 tab-pane fade" id="help" role="tabpanel" aria-labelledby="help-tab">
            {% include "Comedor/layouts/ayuda.twig.php" %}
        </div>
    </div>
    <div class="line"></div>
{% endblock %}