let editor, mytinymce;

// set minheight of .inner-main element
$(".inner-main").css({
	minHeight: $(document).height() - 180
});

// toggle notification in header
$(".notif-toggle").click(function() {
	$.ajax({
		url: base_url + '/notifications/read',
		beforeSend: function() {
			$(".notif-count").html(0);
		},
		success: function(data) {

		}
	});
	$(this).parent().addClass('open');
	return false;
});

// search menu functionality
let search_menu = function() {
	$(".search-menu").each(function() {
		let $this = $(this),
				target = $($this.attr('data-target')).find("li").not(".search-menu");

		$this.find("input").keyup(function() {
			let $item = $(this);
			if($item.val().length > 0) {
				target.hide().filter(function() {
					return $(this).text().toLowerCase().indexOf($this.find("input").val().toLowerCase()) != -1;
				}).show();
			}else{
				target.show();
			}
		});
	});	
}

// tree menu/dropdown in sidemenu
$("li.has-tree > a").click(function() {
	let $this = $(this);

	$(".sidemenu-inner > ul > li").each(function(i) {
		if(i != $this.parent().index()) {
			$(this).removeClass("active");
		}
	});
	$this.parent().toggleClass("active");
	return false;
});

// add title automatically
$(".sidemenu ul li ul.grid li a").each(function() {
	$(this).attr('title', $(this).find("div").html());
});

// initialization bootstrap plugin
let bs_plugin = function() {
	$("[data-toggle=tooltip]").tooltip();
	$("[data-toggle=popover]").popover();
}

// inititialization all jQuery plugin
let init = function() {
	$("form[data-delete]").each(function() {
		let $this = $(this);
		$(this).on("click", ".delete-button", function(e) {
			swal({
				title: 'Delete',
				text: 'Your data will be deleted permanently and this action can\'t be undone. Do you want to continue?',
				icon: 'warning',
				buttons: true,
				dangerMode: true
			}).then((willDelete) => {
				if(willDelete) {
					$this.submit();
				}else{

				}
			});

			e.preventDefault();
		});
	});

	mytinymce = tinymce.init({ 
		selector:'.editor',
	  plugins: 'hr',
	  height: 120,
	  menubar: false,
	  setup: function (editor) {
	    editor.on('change', function () {
	        tinymce.triggerSave();
	    });
	  }
	});

	$(".datepicker").datepicker({
		format: "yyyy-mm-dd"
	});
	$(".timepicker").timepicker();

	$("input").iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  cursor: true
	});

	if($(".currency").length) {
		var cleave = new Cleave('.currency', {
		    numeral: true,
		    numeralThousandsGroupStyle: 'thousand',
		    delimiter: '.'
		});	
	}

	$(".code").each(function() {
		editor = CodeMirror.fromTextArea(this, {
		  lineNumbers: true,
		  theme: "neo"
		});
		editor.setSize("100%", 100);
	});
}

init();

// destroying some of jquery plugins
let destroy = function() {
	if(typeof editor == 'object') {
		editor.toTextArea();	
	}
	tinyMCE.remove();

	$("input").iCheck('destroy');
}

// Bootstrap reusable function
let bsModal = {
	// Private property
	_element: '<div class="modal fade" id="bsmodal"><div class="modal-dialog {size}"><div class="modal-content"><div class="modal-header"><h4>{title}</h4></div><div class="modal-body">{body}</div><div class="modal-footer">{footer}</div></div></div></div>',

	load: function(url) {
		let result;
		$.ajax({
			url: url,
			dataType: 'json',
			beforeSend: function() {
				result = "Loading ...";
			},
			complete: function() {
			},
			success: function(data) {
				let converter = new showdown.Converter();
				$("#bsmodal .modal-body").html(converter.makeHtml(data.data));
			}
		});
		return result;
	},
	hide: function() {
		$("#bsmodal").modal('hide');
		setTimeout(function() {
			$("#bsmodal").remove();
		}, 300);
	},
	create: function(data, oncreate) {
		let _create = function() {		
			let element = bsModal._element;
					if(data.title)
					element = element.replace(/{title}/g, data.title);
					if(data.body)
						element = element.replace(/{body}/g, data.body);
					if(data.bodyLoad)
						element = element.replace(/{body}/g, bsModal.load(data.bodyLoad));

			element = element.replace(/{footer}/g, '');
			element = element.replace(/{size}/g, (data.class ? data.class : 'modal-md'));

			let options;
			if(data.options) {
				options = data.options;
			}else{
				options = {};
			}
			element = $(element).modal(options);

			$("body").append(element);
			if(oncreate)
				oncreate.call(this, $("#bsmodal"));
		
			if(data.buttons) {
				data.buttons.forEach((_button) => {
				  let __button = "<button class='" + _button.class + "' " + (_button.role == 'close' ? "data-dismiss='modal'" : '') + ">" + _button.text + "</button>";
				  __button = $(__button);
				  __button.click(function() {
				  	_button.handler.call(this, $("#bsmodal"), $(this));
				  });
				  $("#bsmodal .modal-footer").append(__button);
				});
			}

			$('#bsmodal').on('hidden.bs.modal', function (e) {
				$("#bsmodal").remove();
			});
		}

		if($("#bsmodal").length) {
			bsModal.hide();
			setTimeout(() => {
			  _create();
			}, 500);
		}else{
			_create();
		}
	}
}

let optional = function(val) {
	if(val == undefined) {
		return null;
	}
	return val;
}

let generate_html = function(html) {
	let regex = [
		/editor-draggable-element/g,
		/ui-([a-zA-Z0-9-]+)/g,
		/data-([a-zA-Z0-9- /\//.="\[\]\{\}\&\:\;\,]+)\"/g,
		/<div class="help-text"><\/div>/g
	];
	regex.forEach((reg) => {
		html = html.replace(reg, "");
	})
	html = html.replace(/ +/g, " ").replace(/ "/g, '"').replace(/" /g, '"');
	html = html_beautify(html, {
		wrap_line_length: 0,
		brace_style: 'expand',
		end_with_newline: true,
		extra_liners: ['/label'],
		preserve_newlines: false
	});
	return html;
}