{% extends 'layout.volt' %}

{% block title %}Post List
{% endblock %}

{% block content %}
	<h1>Backend Dashboard</h1>
	<a href="{{ url('/admin/post/create') }}" class="btn btn-primary">Create New Post</a>

	{# <!-- Filter Form -->
	<form method="get" action="{{ url(['for': 'adminpost-index']) }}" class="filter-form">
		<select name="user_id">
			<option value="">All Users</option>
			{% for user in users %}
				<option value="{{ user.getId() }}" {% if user.getId() == filter_user_id %}selected{% endif %}>
					{{ user.getUsername() }}
				</option>
			{% endfor %}
		</select>

		<input type="text" name="title" placeholder="Search Title" value="{{ filter_title }}">
		<input type="date" name="from_date" value="{{ filter_from_date }}">
		<input type="date" name="to_date" value="{{ filter_to_date }}">

		<button type="submit" class="btn btn-filter">Filter</button>
	</form> #}
	<form method="get" action="{{ url(['for': 'adminpost-index']) }}" class="filter-form">
		{{ form.label('user_id') }}
		{{ form.render('user_id') }}

		{{ form.label('title') }}
		{{ form.render('title') }}

		{{ form.label('from_date') }}
		{{ form.render('from_date') }}

		{{ form.label('to_date') }}
		{{ form.render('to_date') }}

		{{ form.render('filter') }}
	</form>

	<table class="post-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>User's Name</th>
				<th>Title</th>
				<th>Created At</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			{% for post in posts %}
				<tr>
					<td>{{ post.getId() }}</td>
					<td>{{ post.getUser().getUsername() }}</td>
					<td>{{ post.getTitle() }}</td>
					<td>{{ formatDate(post.created_at, 'd/m/Y') }}</td>
					<td>
						<a href="{{ url(['for': 'adminpost-update', 'id': post.getId()]) }}" class="btn btn-update">Update</a>
						<a href="{{ url(['for': 'adminpost-delete', 'id': post.getId()]) }}" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this post?');">
							Delete
						</a>
					</td>
				</tr>
			{% endfor %}
		</tbody>
	</table>

	{% for type, messages in flashSession.getMessages() %}
		{% for message in messages %}
			<div class="flash-message {{ type }}">
				{{ message }}
			</div>
		{% endfor %}
	{% endfor %}
{% endblock %}
