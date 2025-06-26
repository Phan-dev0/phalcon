{% extends 'layout.volt' %}

{% block title %}Update Post
{% endblock %}

{% block content %}
	<div class="form-container">
		<a href="{{ url(['for': 'adminpost-index']) }}" class="back-link">Back</a>
		<h2>Update Post</h2>
		<form method="post" action="{{ url(['for': 'adminpost-update', 'id': postId]) }}" class="post-form">
			<input type='hidden' name='<?php echo $this->security->getTokenKey() ?>' value='<?php echo $this->security->getToken() ?>'/>
			<label>User:</label><br>
			{{ form.render("user_id")}}
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'user_id' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<label>Title:</label><br>
			{{ form.render("title")}}
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'title' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<label>Content:</label><br>
			{{ form.render("content")}}
			{% if errors is defined %}
				{% for error in errors %}
					{% if error.getField() == 'content' %}
						<span class="error">{{ error.getMessage() }}</span><br>
					{% endif %}
				{% endfor %}
			{% endif %}
			<br>

			<button type="submit" class="btn-submit">Update</button>
		</form>
	</div>
{% endblock %}


{# <form method="post" action="{{ url('/admin/post/update/' ~ post.getId()) }}" class="post-form">
	<label>User:</label><br>
	<select name="user_id">
		<option value="">-- Select User --</option>
		{% for user in users %}
			<option value="{{ user.getId() }}" {% if post.getUserId() == user.getId() %} selected {% endif %}>
				{{ user.getId() }}
				-
				{{ user.getUsername() }}
			</option>
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
	<input type="text" name="title" value="{{ post.getTitle() }}"><br>
	{% if errors is defined %}
		{% for error in errors %}
			{% if error.getField() == 'title' %}
				<span class="error">{{ error.getMessage() }}</span><br>
			{% endif %}
		{% endfor %}
	{% endif %}
	<br>

	<label>Content:</label><br>
	<textarea name="content">{{ post.getContent() }}</textarea><br>
	{% if errors is defined %}
		{% for error in errors %}
			{% if error.getField() == 'content' %}
				<span class="error">{{ error.getMessage() }}</span><br>
			{% endif %}
		{% endfor %}
	{% endif %}
	<br>

	<button type="submit" class="btn-submit">Update</button>
</form> #}
