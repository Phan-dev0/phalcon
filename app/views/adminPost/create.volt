{% extends 'layout.volt' %}

{% block title %}Create Post
{% endblock %}

{% block content %}
	<div class="form-container">
		<a href="{{ url(['for': 'adminpost-index']) }}" class="back-link">Back</a>
		<h2>Create New Post</h2>
		<form method="post" action="{{ url(['for': 'adminpost-create-post']) }}" class="post-form">
			<input type='hidden' name='<?php echo $this->security->getTokenKey() ?>' value='<?php echo $this->security->getToken() ?>'/>

			<label>User:</label><br>
			{{ form.render("user_id") }}
			<br>
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'user_id' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<label>Title:</label><br>
			{{form.render("title")}}
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'title' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<label>Content:</label><br>
			{{form.render("content")}}
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'content' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<button type="submit" class="btn-submit">Create</button>
		</form>
	</div>
{% endblock %}

{# <form method="post" action="{{ url('/admin/post/create') }}" class="post-form">
	<label>User:</label><br>
	<select name="user_id">
		<option value="">-- Select User --</option>
		{% for user in users %}
			<option value="{{ user.getId() }}">{{ user.getId() }}
				-
				{{ user.getUsername() }}</option>
		{% endfor %}
	</select><br>
	{% if errors is defined %}
		{% for error in errors %}
			{% if error.getField() == 'user_id' %}
				<span class="error">{{ error.getMessage() }}</span><br>
			{% endif %}
		{% endfor %}
	{% endif %}
	<br>

	<label>Title:</label><br>
	<input type="text" name="title"><br>
	{% if errors is defined %}
		{% for error in errors %}
			{% if error.getField() == 'title' %}
				<span class="error">{{ error.getMessage() }}</span><br>
			{% endif %}
		{% endfor %}
	{% endif %}
	<br>

	<label>Content:</label><br>
	<textarea name="content"></textarea><br>
	{% if errors is defined %}
		{% for error in errors %}
			{% if error.getField() == 'content' %}
				<span class="error">{{ error.getMessage() }}</span><br>
			{% endif %}
		{% endfor %}
	{% endif %}
	<br>

	<button type="submit" class="btn-submit">Create</button>
</form> #}
