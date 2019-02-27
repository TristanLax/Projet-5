<img src="{{ vich_uploader_asset(post, 'imageFile') | imagine_filter('thumb') }}">

{# templates/projet/edit.html.twig #}
{% extends 'base.html.twig' %}


{% block title %} Editer {% endblock %}


{% block body %}

        
        <h2>Editer le post :</h2>
        <div>
            {{ form_start(form) }}
            
            {% for picture in post.pictures %}
            {% endfor %}
            
                                        <div class="col">
                            <img src="{{ vich_uploader_asset(picture, 'imageFile') }}" width="100%" alt="">
                            </div>
            {{ form_widget(form) }}
            <button class="btn btn-secondary">Enregistrer</button>
            {{ form_end(form) }}
        </div>




{% endblock %}