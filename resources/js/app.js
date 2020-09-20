function main(e) {
	$("select[name='locale']").change(function($e) {
		Api.Locale.change(this.value, function() {
			location.reload();
		});
	})
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
			$.ajax(Api.makeUrl(), {
				data: {
					locale: locale
				},
				complete: callback
			});
		}
	}
}

document.addEventListener("DOMContentLoaded", main);
