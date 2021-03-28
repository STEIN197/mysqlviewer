<div class="d-flex js-split-pane crop" style="flex-grow:1">
	<section id="sidebar" class="split-pane" data-size="20">
		<x-sidebar/>
	</section>
	<section id="content" class="split-pane" data-size="80">
		<textarea style="width:100%;resize:none" rows="10"></textarea>
		<button class="btn btn-primary btn-sm js-query">Запрос</button>
		{{-- <div id="editor"></div> --}}
		<div id="result"></div>
	</section>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		$(".js-query").click(async () => {
			let result = await axios.get("/api/sql/", {
				params: {
					query: $("textarea").val()
				}
			});
			$("#result").html(result.data.message || result.data.data);
		});
		// var editor = ace.edit("editor");
		// editor.setTheme("ace/theme/monokai");
		// editor.session.setMode("ace/mode/sql");
	});
</script>
