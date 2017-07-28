<?php
$posts = new Posts();

if($posts->count()!=0) {
	foreach($posts->get() as $post) {
		$posts->show($post);
	}
} else {
	echo "<div class='notify mb'><div class='icon'></div><div class='text'>Unfortunately there are no articles.</div><div class='close'><i></i></div></div>";
	echo "<article>
		<div class='header'>
			<span class='title'>Welcome</span>
		</div><div class='text'>Welcome to the official website of the World Fudokan Federation.</div>
	</article>";
}
/*<article>
	<div class="header">
		<span class="title">Naslov</span>
	</div><div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
</article>
<article class="mt">
	<div class="header">
		<span class="title">Naslov</span>
		<span class="date">00.00.0000.</span>
		<div class="settings">
			<i class="settings_icon"></i>
			<div class="settings_dropdown">
				<span>Edit</span>
				<span>Delete</span>
			</div>
		</div>
	</div><div class="image">
		<img src="<?= $imgspath;?>cover.jpg">
	</div><div class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
</article>*/
?>
