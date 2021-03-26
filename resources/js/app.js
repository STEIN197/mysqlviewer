function DOMBuilder(){var t=[];this.tag=function(e,o,i){var u=document.createElement(e),a=r(o,i),f=n(o,i);if(a)for(var l in a)u.setAttribute(l,a[l]);if(f)if("function"==typeof f){var c=new DOMBuilder,s=f(c),d=c.getNodes();for(var p in d)u.appendChild(d[p]);null!=s&&u.append(s)}else if(f instanceof DOMBuilder){var h=f.getNodes();for(var p in h)u.appendChild(h[p])}else u.textContent=f;return t.push(u),this},this.getNodes=function(){return t},this.toString=function(){return e(t)};var e=function(t){var n="";for(var r in t){var o=t[r],i=o.tagName.toLowerCase(),u=o.attributes,a=[];for(r=0;r<u.length;r++)a.push(u[r].nodeName+'="'+u[r].value+'"');a.length&&(a=" "+a.join(" ")),n+="<"+i+a+">",o.children.length?n+=e(Array.prototype.slice.call(o.children)):n+=o.textContent,n+="</"+i+">"}return n},n=function(t,e){return t&&"object"!=typeof t?t:e&&"object"!=typeof e?e:null},r=function(t,e){return t&&"object"==typeof t?t:e&&"object"==typeof e?e:null}}

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

	Accordion.init();
	$(".js-create-column").click(async function () {
		let tr = await axios.get('/api/create/column/', {
			params: {
				index: this.getAttribute("data-index")
			}
		});
		$(this).closest("table").find("tbody").append(tr.data);
		this.setAttribute("data-index", +this.getAttribute("data-index") + 1);
	});
	$(".table-columns tbody").delegate("tr.new td:first-child a", "click", function () {
		this.closest("tr").remove();
	});
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
		onToggle: function() {
			
		}
	}
}

document.addEventListener("DOMContentLoaded", main);
