{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header class="item">
        <h1>Content</h1>
    </header>
    
    <form action="/backend/content/create" method="post"> 
        <div class="form-group">
          <label>Title</label>
          <input name="title" placeholder="Content Title" value="{{ formVars.Title }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Slug</label>
          <input name="slug" placeholder="Slug" value="{{ formVars.slug }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Body</label>
          <textarea name="body" placeholder="body" class="input-control"></textarea>
        </div>
      
        <div class="form-group">
          <label>Author</label>
          <input name="author" placeholder="Author #" value="{{ formVars.author }}" class="input-control" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Save</button>
          <button>Cancel</button>
        </div>
    </form>
    
</article>
{% endblock %}