<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<div id="editor"></div>
	</section>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		var editor = ace.edit("editor");
		editor.setTheme("ace/theme/monokai");
		// editor.session.setMode("ace/mode/sql");
	});
</script>
