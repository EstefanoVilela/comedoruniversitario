<h3>Ayuda</h3><hr>
<section class="row">
    <div class="col-md-6">
        <h5>Preguntas frecuentes</h5>

        {% for a in ayudas %}
            <b>{{ a.titulo_ayuda }}</b>
            <p class="text-justify">{{ a.nom_ayuda }}</p>
        {% endfor %}
    </div>

    <div class="col-md-6">
        <img src="assets/img/sl07_2.jpg" alt="" width="100%" class="mb-2" />
        <img src="assets/img/comedor.jpg" alt="" width="100%" class="mb-2" />
    </div>
</section>