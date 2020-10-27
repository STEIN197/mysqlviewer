function main(e) {
	$("select[name='locale']").change(function($e) {
		Api.Locale.change(this.value, function() {
			location.reload();
		});
	});

	$(".js-split-pane").each(function() {
		Split($(this).children().toArray(), {
			gutterSize: 6,
			sizes: [].slice.call(this.children).map(e => +e.getAttribute("data-size"))
		});
	});

	$(".js-accordion-button").click(toggleAccordion);
	$("body").css("opacity", 1);
}

var Api = {
	PREFIX: "api",
	makeUrl: function(path) {
		var prefix = "/" + Api.PREFIX + "/";
		var result;
		if (path)
			result = prefix + path + "/";
		else
			result = prefix;
		return result.replace(/\/{2,}/g, "/");
	},
	Locale: {
		change: function(locale, callback) {
			axios.get(Api.makeUrl(), {
				params: {
					locale: locale
				}
			}).then(callback);
		}
	},
	Sidebar: {
		
	}
}

function toggleAccordion($e) {
	$e.preventDefault();
	var $item = $(this).closest(".js-accordion-item");
	var bodies = $item.find(".js-accordion-body").toArray();
	var $body = $(bodies[0]);
	for(var i = 1; i < bodies.length; i++){
		var $tmpBody = $(bodies[i]);
		if($tmpBody.parents().length < $body.parents().length)
			$body = $tmpBody;
	}
	if ($body.is(":animated"))
		return;
	$body.slideToggle();
	var $wrapper = $item.parents(".js-accordion").first();
	if($wrapper.hasClass("singlemode") && !$item.hasClass("expanded")){
		var expanded = $wrapper.find(".js-accordion-item.expanded").toArray();
		var $expanded = $(expanded[0]);
		for(var i = 1; i < expanded.length; i++){
			var $tmpExpanded = $(expanded[i]);
			if($tmpExpanded.parents().length < $expanded.parents().length)
				$expanded = $tmpExpanded;
		}
		$expanded.removeClass("expanded").addClass("collapsed");
		bodies = $expanded.find(".js-accordion-body");
		$body = $(bodies[0]);
		for(var i = 1; i < bodies.length; i++){
			var $tmpBody = $(bodies[i]);
			if($tmpBody.parents().length < $body.parents().length)
				$body = $tmpBody;
		}
		$body.slideUp();
	}
	$item.toggleClass("expanded").toggleClass("collapsed");
}

document.addEventListener("DOMContentLoaded", main);
