<h1>Liste des Posts</h1>
<ul>
  @foreach($posts as $post)
  <li>{{ $post->title }}</li>
  @endforeach
</ul>
