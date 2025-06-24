{% extends 'layout.volt' %}

{% block title %}Post List
{% endblock %}

{% block content %}
	<h1>Backend Dashboard</h1>
	<a href="{{url(['for': 'post-create'])}}" class="btn btn-primary">Create New Post</a>

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
					<td>{{ post.getCreatedAt() }}</td>
					<td>
						<a href="{{ url(['for': 'post-update', 'id': post.getId()]) }}" class="btn btn-update">Update</a>
						<a href="{{ url(['for': 'post-delete', 'id': post.getId()]) }}" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this post?');">
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
