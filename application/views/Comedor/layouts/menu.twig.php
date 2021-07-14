<h3>Menú semanal</h3><hr>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                {% for d in dias %}
                    <th width="10%">{{ d.nom_dia }}</th>
                {% endfor %}
            </tr>
        </thead>

        <tbody>
            {% set cont = 1 %}

            {% for c in comidas %}
                {% if cont == 1 %}
                    <tr>
                {% endif %}

                <td>
                    <b>{{ c.nom_tcomida }}</b>
                    <hr>
                    <p>{{ c.bebida }}</p>
                    <p>{{ c.item_1 }}</p>
                    <p>{{ c.item_2 }}</p>
                    <p>{{ c.postre }}</p>
                </td>

                {% if cont == 5 %}
                    </tr>
                    {% set cont = 0 %}
                {% endif %}

                {% set cont = cont +1 %}
            {% endfor %}
        </tbody>
    </table>
</div>