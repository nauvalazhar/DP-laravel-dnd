@extends('layouts.app', ['title' => 'Module Builder', 'menu' => false])

@section('sidemenu')
<ul>
	<li>
		<a href="{!! route('dashboard') !!}">
			<i class="ion ion-ios-arrow-left"></i> Back
		</a>
	</li>
	<li class="has-tree active">
		<a role="button">
			<i class="ion ion-grid"></i> Components <span class="caret"></span>
		</a>
		<ul id="toolbox" class="grid components">
			<li class="search-menu" data-target="#toolbox">
				<input type="text" class="form-control" placeholder="Search components" id="search-components">
			</li>
		</ul>
	</li>
</ul>
@stop

@section('content')
	@component('layouts.parts.header', ['title' => 'Module Builder'])

	<div class="inspector">
	</div>
	<div class="pull-right">
		<a role="button" class="btn btn-danger tips" onclick="editor_area.tips()"><i class="ion ion-ios-lightbulb-outline"></i> Tips</a>
		<a role="button" class="btn btn-primary preview" onclick="editor_area.preview(event)"><i class="ion ion-play"></i> Preview</a>
		<div class="btn-divider"></div>
		<div class="dropdown d-inline-block">
			<a role="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="ion ion-code"></i> Tools <span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left">
				<li><a role="button" id="module-setting">Module Setting ...</a></li>
				<li class="divider"></li>
				<li><a role="button" id="module-generate"><i class="ion ion-code-working"></i> Generate Module</a></li>
				<li><a role="button" id="module-export"><i class="ion ion-ios-download-outline"></i> Export</a></li>
				<li><a role="button" id="module-import"><i class="ion ion-ios-upload-outline"></i> Import</a></li>
			</ul>
		</div>
	</div>
	@endcomponent

	<div id="editor_area"></div>
	<textarea id="source_area" class="hide"></textarea>
@stop

@section('foot')
<script>
	let is_recover = false,
			is_ws = false;

	// Recover layout
	let _saved_layout = localStorage.getItem("_starterkit_module_layout"),
			_saved_setting = localStorage.getItem("_starterkit_module_setting");
			_saved_setting = JSON.parse(_saved_setting);

	if(_saved_layout && _saved_layout !== '{"node":"root","child":[]}') {
		is_recover = true;
		setTimeout(() => {
			localStorage.setItem('_starterkit_module_layout', _saved_layout);
		}, 1000);
		bsModal.create({
			title: '<i class="ion ion-heart-broken"></i> Recover Layout',
			body: 'We have found your last work <code>'+(_saved_setting.display_name ? _saved_setting.display_name : 'Untitled Module')+'</code>, would you like to recover it?',
			options: {
				backdrop: 'static'
			},
			buttons: [
				{
					text: 'Recover',
					class: 'btn btn-primary',
					handler: function(b) {
						localStorage.setItem('_starterkit_module_layout', _saved_layout);
						selector.source_area.val(_saved_layout);
						source.init();
						bsModal.hide();
					}
				},
				{
					text: 'Destroy',
					class: 'btn btn-default',
					handler: function(b) {
						localStorage.removeItem('_starterkit_module_layout');
						localStorage.removeItem('_starterkit_module_setting');
						welcome_screen();
					}
				}
			]
		});
	}

	let welcome_screen = function() {
		let ws_body = "";
				ws_body += '<p>Lets create your module easly, just drag and drop component you want inside droppable area. Before started you should read the <a role="button" onclick="editor_area.tips(true);">intruction</a> for more help. Or you can <a role="button" onclick=\'$("#module-import").click();\'>import an already layout</a>.</p>';
				ws_body += '<div class="row">';
				ws_body += '<div class="col-md-6">';
				ws_body += '<div class="form-group">';
				ws_body += '<label>Name</label>';
				ws_body += '<input type="text" class="form-control" id="ws-name" placeholder="e.g: blog_post">';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '<div class="col-md-6">';
				ws_body += '<div class="form-group">';
				ws_body += '<label>Display Name</label>';
				ws_body += '<input type="text" class="form-control" id="ws-display-name" placeholder="e.g: Blog Post">';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '<div class="row type-group">';
				ws_body += '<div class="col-md-12">';
				ws_body += '<div class="form-group">';
				ws_body += '<label>Type</label>';
				ws_body += '<p>Choose type of your module.</p>';
				ws_body += '<div class="row">';
				ws_body += '<div class="col-md-4">';
				ws_body += '<div class="type-item">';
				ws_body += '<img src="'+base_url+'/img/builder/type-loop.png">';
				ws_body += '<input type="radio" name="ws_type" value="loop">';
				ws_body += '<h4>Loop</h4>';
				ws_body += '<p>You can create more than one record, recommended if you want create module for blog post, pages, etc.</p>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '<div class="col-md-4">';
				ws_body += '<div class="type-item">';
				ws_body += '<img src="'+base_url+'/img/builder/type-single.png">';
				ws_body += '<input type="radio" name="ws_type" value="single">';
				ws_body += '<h4>Single</h4>';
				ws_body += '<p>You only can update an available record this is recommended if you want create module for contact info, etc.</p>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '<div class="col-md-4">';
				ws_body += '<div class="type-item">';
				ws_body += '<img src="'+base_url+'/img/builder/type-sortable.png">';
				ws_body += '<input type="radio" name="ws_type" value="sortable">';
				ws_body += '<h4>Sortable</h4>';
				ws_body += '<p>Sortable allow you to sort the available record. Recommended if you want create module for categories, dynamic menus, etc.</p>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '</div>';
				ws_body += '</div>';

		bsModal.create({
			options: {
				backdrop: 'static'
			},
			class: 'modal-lg',
			title: '<i class="ion ion-erlenmeyer-flask"></i> Welcome to Builder',
			body: ws_body,
			buttons: [
				{
					text: 'Get Started',
					class: 'btn btn-primary',
					handler: function(b) {
						let name = b.find(".modal-body #ws-name").val(),
								display_name = b.find(".modal-body #ws-display-name").val(),
								type = b.find(".modal-body [name='ws_type']:checked").val();

						if(!name) {
							b.find(".modal-body #ws-name").focus();
							return;
						}else if(!display_name) {
							b.find(".modal-body #ws-display-name").focus();
							return;
						}else if(!type) {
							b.find(".modal-body .type-group").addClass("highlight");
							setTimeout(() => {
								b.find(".modal-body .type-group").removeClass("highlight");
							}, 1000);
							return;
						}

						let setting = {
							name: name,
							display_name: display_name,
							type: type
						}
						localStorage.setItem("_starterkit_module_setting", JSON.stringify(setting));
						bsModal.hide();
						is_ws = false;
					}
				},
				{
					text: 'Back to Dashboard',
					class: 'btn btn-default',
					handler: function() {
						document.location = '{{route('dashboard')}}';
					}
				}
			]
		}, function(b) {
			b.find(".type-item").click(function() {
				b.find(".type-item").removeClass('active');
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$(this).find("input").prop("checked", false);
				}else{
					$(this).addClass('active');
					$(this).find("input").prop("checked", true);
				}
			});
		});
	}

	if(is_recover == false) {
		welcome_screen();
		is_ws = true;
	}

	let selector = {
		toolbox: $("#toolbox"),
		editor_area: $("#editor_area"),
		inspector: $(".inspector"),
		source_area: $("#source_area")
	}

	let request_url = {
		components: '{{ route('starterkit.file', ['json', 'components']) }}',
		intructions: '{{ route('starterkit.file', ['md', 'intructions']) }}',
		generate: '{{ route('modules.generate') }}'
	}

	$(document).on('keydown', function(e) {
		if(e.ctrlKey) {
			if(e.keyCode == 80) {
				$(".preview").click();
				return false;
			}
		}
		if(e.key == 'F1') {
			if(!$("body").hasClass("modal-open")) {
				$(".tips").click();
			}
			return false;
		}
		
		if(e.key == 'F3') {
			$("#search-components").focus();
			return false;
		}
	});

	let source = {
		init: function() {
			let _source = selector.source_area.val();

			if(_source) {
				let html = source.toHTML(_source);
				editor_area.update(html);
			}else{
				source.update();			
			}
		},
		toHTML: function(html) {
			return json2html(JSON.parse(html));
		},
		update: function() {
			let _source = selector.editor_area.html();
					_source = $(_source);
					_source = $("<div>").append(_source);
					_source.find(".ui-draggable-dragging").remove();
					_source.find(".has-focused").removeClass('has-focused');
					_source = _source.html();
			let parse = html2json(_source);
					parse = JSON.stringify(parse);

			selector.source_area.val(parse);

			localStorage.setItem('_starterkit_module_layout', parse);
		}
	}
	selector.source_area.on("input", function() {
		source.init();
	});
	source.init();

	let toolbox_data, toolbox = {
		options: {
			revert: "invalid",
			cursorAt: { top: 30, left: 30 },
			helper: "clone",
			cursor: "move",
			start: function() {
				let pos = $(".sidemenu-inner").scrollTop();
				$(".sidemenu-inner").css({
					overflow: 'initial',
					top: -(pos-60)
				});
			},
			stop: function() {
				$(".sidemenu-inner").css({
					overflow: 'auto',
					top: 60
				})
			}
		},
		add: function(elem) {
			selector.toolbox.append(elem);
			selector.toolbox.find("li:not(.header)").addClass("toolbox-item").draggable(toolbox.options);
			search_menu();
		},
		remove: function(sele) {
			selector.toolbox.find(sele).remove();
		},
		findByName: function(name) {
			let findByName = _(toolbox_data)
												.chain()
												.pluck('children')
												.flatten()
												.findWhere({name: name})
												.value();

			return findByName;
		},
		init: function() {
			toolbox.render();
		},
		load: function(success) {
			let result;
			$.ajax({
				url: request_url.components,
				dataType: 'json',
				beforeSend: function() {
					toolbox.add('<li id="loading-component">Loading Components ...</li>');
				},
				complete: function() {
					toolbox.remove("#loading-component");
				},
				success: function(data) {
					result = data;
					success.call(this, data);
				}
			});
		},
		_extract: function(obj) {
			obj.forEach((comps) => {
				toolbox.add("<li id='group-" + comps.name + "' class='header'>" + comps.display_name + "</li>");
				if(comps.children) {
					comps.children.forEach((child) => {
						let _item = "<li>";
								_item += "<a role='button' id='tool-" + child.name + "' class='tool-item-" + child.name + "' data-item-name='" + child.name + "' title='" + child.display_name + "'>";
								_item += child.icon;
								_item += "<div>" + child.display_name + "</div>";
								_item += "</a>";
								_item += "</li>";
					  toolbox.add(_item);
					});
				}
			});
		},
		render: function() {
			toolbox.load(function(data) {
				if(typeof data == 'object') {
					toolbox._extract(data.data);
					toolbox_data = data.data;
				}
			});
		}
	}
	toolbox.init();

	let selected_element_object, selected_element, editor_area = {
		options: {
			accept: ".components li:not(.header), .editor-draggable-element",
			greedy: true,
			hoverClass: "droppable-hover",
			tolerance: 'pointer',
	    classes: {
	      "ui-droppable-active": "ui-state-highlight"
	    },
	    over: function(ev, ui) {
	    	console.log(ev)
	    },
			drop: function(ev, ui) {
				var toolbox_item = $(ui.draggable).find("a"),
						toolbox_item_name = toolbox_item.data('item-name'),
						_html;

				let toolbox_item_object = toolbox.findByName(toolbox_item_name),
						toolbox_item_element;

				if(!$(ui.draggable).hasClass('toolbox-item')) {
					toolbox_item = $(ui.draggable);
					toolbox_item_name = editor_area.droppedGet(toolbox_item);
					toolbox_item.removeClass('origin-element');
					_html = toolbox_item;
					$(".origin-element").remove();
				}else{
					_html = $(toolbox_item_object.html);
				}

				selected_element_object = toolbox_item_object;
				if(!selected_element_object) {
					selected_element_object = toolbox.findByName(editor_area.droppedGet(toolbox_item));
				}

				if(typeof selected_element_object == 'object') {
					toolbox_item_element = _html;
				}else{
					swal('Whoopss', 'Sorry, element not recognized.');
					return;
				}

				editor_area.drop($(this), toolbox_item_element);
			}
		},
		update: function(html) {
			selector.editor_area.html(html);
			editor_area.elementFunction(selector.editor_area.find(".editor-draggable-element"));
			editor_area.check();
		},
		droppedSet: function(elem, name) {
			elem.attr('data-element-name', name);
		},
		droppedGet: function(elem) {
			return elem.attr('data-element-name');
		},
		draggable_options: {
			cancel: false,
			revert: 'invalid',
			tolerance: "pointer",
			cursorAt: {
				top: 0,
				left: 0
			},
			helper: function() {
				let _this_draggable = $(this).clone();
				$(this).addClass('origin-element');
				return _this_draggable;
			}
		},
		drop: function(target_drop, elem) {
			editor_area.droppedSet(elem, selected_element_object.name);
			elem = editor_area.elementFunction(elem);
			target_drop.append(elem);
			editor_area.check();

			source.update();
		},
		elementFunction: function(elem) {
			elem.addClass("editor-draggable-element");
			elem.droppable(editor_area.options);
			elem.draggable(editor_area.draggable_options);
			elem.on("contextmenu", editor_area.inspect);
			elem.on("click", function() {
				return false;
			});
			return elem;
		},
		inspect: function(e) {
			selected_element = $(e.target);
			if(!selected_element.hasClass('editor-draggable-element')) selected_element = selected_element.closest('.form-group');
			selected_element_name = editor_area.droppedGet(selected_element),
			selected_element_object = toolbox.findByName(selected_element_name);

			all_elements = $('.editor-draggable-element');

			if(selected_element.hasClass('editor-draggable-element') && !editor_area.isPreview()) {
				all_elements.removeClass('has-focused');
				selected_element.addClass('has-focused');
				inspector.run();
			}

			e.preventDefault();
		},
		selectedSet: function(name, value) {
			selected_element.attr('data-store-' + name, value);
		},
		selectedGet: function(name) {
			return selected_element.attr('data-store-' + name);
		},
		check: function() {
			if(selector.editor_area.html().length < 1) {
				selector.editor_area.addClass("has-empty");
				selector.editor_area.html("<div class='text'>Drop your components here <div class='p'>When you create the layout you have to click the <code>preview</code> button to see your layout as expected.</div></div>");
			}else{
    		selector.editor_area.removeClass("has-empty");
    		selector.editor_area.find(".text").remove();
			}
		},
		init: function() {
			editor_area.check();
			selector.editor_area.droppable(editor_area.options);
		},
		tips: function(_ws) {
			let buttons;
			if(_ws) {
				buttons = [{
					text: 'Back',
					class: 'btn default',
					handler: function() {
						welcome_screen();
					}
				}]
			}else{
				buttons = [{
					text: 'Yes, i got it!',
					class: 'btn btn-primary',
					role: 'close'
				}]
			}

			bsModal.create({
				title: '<i class="ion ion-ios-lightbulb-outline"></i> Tips',
				bodyLoad: request_url.intructions,
				buttons: buttons
			});
		},
		preview: function(e) {
			inspector.destroy();
			let preview_button = $(".btn.preview");

			if(!selector.editor_area.hasClass('mode-preview')) {
				selector.editor_area.addClass('mode-preview');
				$('.editor-draggable-element').draggable('disable');				
				$('.editor-draggable-element').attr('data-editor-draggable-element', true);
				$('.editor-draggable-element').removeClass('editor-draggable-element');				
				$(".sidemenu").append("<div class='sidemenu-overlay'></div>");
				preview_button.html("<i class='ion ion-settings'></i> Editor Mode");

				// Initialization jQuery plugins
				init();
			}else{
				selector.editor_area.removeClass('mode-preview');
				$('.editor-draggable-element').removeAttr('data-editor-draggable-element');
				$('[data-editor-draggable-element]').addClass('editor-draggable-element');
				$('.editor-draggable-element').draggable('enable');				
				$(".sidemenu .sidemenu-overlay").remove();
				preview_button.html("<i class='ion ion-ios-play'></i> Preview");

				// Destroy jQuery plugins
				destroy();
			}
		},
		isPreview: function() {
			if(selector.editor_area.hasClass("mode-preview")) {
				return true;
			}else{
				return false;
			}
		}
	}
	editor_area.init();

	let inspector_modal, count_list = 0, inspector = {
		reset: function() {
			selector.inspector.html("");
		},
		add: function(elem) {
			selector.inspector.append(elem);
		},
		addItem: function(id, elem) {
			selector.inspector.find('#inspector-group-' + id).append($("<div/>", {
				class: "inspector-control-group"
			})
			.append($("<label/>", {
				html: elem[0]
			}))
			.append($("<div/>", {
				class: "inspector-control",
				html: elem[1]
			})));
		},
		addGroup: function(title, id) {
			let create_group = $("<div/>", {
				id: 'inspector-group-' + id,
				class: 'inspector-group',
				html: '<h5>' + title + '</h5>'
			});
			selector.inspector.find(".inspector-group-inner").append(create_group);
		},
		addBlock: function(id, elem) {
			selector.inspector.find('#inspector-group-' + id).append($("<div/>", {
				class: "inspector-control-group"
			})
			.append($("<div/>", {
				html: elem
			})));
		},
		editable: function(value, selected_editable, opt) {
			_selected_element = selected_element;
			selected_element = (selected_editable.find !== undefined ? selected_element.find(selected_editable.find) : selected_element);

			// store to selected element as temporary attribute
			if(selected_editable.type == 'select') {
				editor_area.selectedSet(opt.name, value);
			}else if(selected_editable.type == 'input') {
				editor_area.selectedSet(selected_editable.name, value);
			}

			// store to selected element as real attribute
			if(selected_editable.selector == 'attr') {
				let attr_value = selected_element.attr(selected_editable.store_to);
				attr_value = (attr_value ? attr_value.trim() : '');

				if(selected_editable.type == 'select') {
					opt.list.forEach((item) => {
					  attr_value = attr_value.replace(" " + item.name, "");
					  attr_value = attr_value.replace(item.name, "");
					});
				}

				if(value !== 'false') {
					if((selected_editable.keep_old == undefined || selected_editable.keep_old == true) && selected_editable.type != 'input') {
						attr_value += ' ' + value;
					}else{
						attr_value = value;
					}
				}

				attr_value = attr_value.trim();
				selected_element.attr(selected_editable.store_to, attr_value);
			}else if(selected_editable.selector == 'html') {
				let html_value = selected_element.html();
				html_value.trim();
				
				if(selected_editable.store_to == 'this') {
					selected_element.html(value);
				}
			}

			selected_element = _selected_element;

			source.update();
		},
		removeElement: function(e) {
			selected_element.remove();
			editor_area.check();
			inspector.destroy();

			source.update();
		},
		createSelect: function(item, option, change) {
			let create_select = '<select class="inspector-input">';
					if(!option.primary) {
						create_select += "<option value='false'>None</option>";
					}
					option.list.forEach((opt) => {
						create_select += "<option value='" + opt.name + "' " + (inspector.getValue(item, option) == opt.name ? 'selected' : '') + ">" + opt.display_name + "</option>";
					});
					create_select += "</select>";

			create_select = $(create_select);
			create_select.on("change", function(e) {
				change.call(this, e);
			});
			return create_select;
		},
		createInput: function(item, keyup) {
			let create_input = '<input class="inspector-input" value="' + inspector.getValue(item) + '" ' + (item.placeholder ? "placeholder='" + item.placeholder + "'" : '') + '>';

			create_input = $(create_input);
			create_input.on("keyup", function(e) {
				keyup.call(this, e);
			});
			return create_input;
		},
		createButton: function(display_name, option, click) {
			let create_button = '<button class="' + option.class + '">';
					create_button += display_name;
					create_button += '</button>';

			create_button = $(create_button);
			create_button.click(function(e) {
				click.call(this, e);
			});
			return create_button;
		},
		getValue: function(selected_editable, option) {
			let get_value;

			// Set selected element as temporary
			_selected_element = selected_element;
			selected_element = (selected_editable.find !== undefined ? selected_element.find(selected_editable.find) : selected_element);

			if(selected_editable.selector == 'html') {
				get_value = editor_area.selectedGet(selected_editable.name);
				if(!get_value) {
					get_value = selected_element.html();
				}
			}else if(selected_editable.selector == 'attr') {
				get_value = editor_area.selectedGet(selected_editable.name);
				if(!get_value) {
					if(typeof option == 'object') {
						let get_attr_value = selected_element.attr(selected_editable.store_to);

						if(get_attr_value) {
							get_attr_value = get_attr_value.split(" ");

						  option.list.forEach((val_from_option) => {
								get_attr_value.forEach((val) => {
							    if(val_from_option.name == val) {
							    	get_value = val;
							    }
							  })
							});							
						}
					}else{
						get_value = selected_element.attr(selected_editable.store_to);
						if(!get_value) {
							get_value = '';
						}
					}
				}
			}

			selected_element = _selected_element;
			return get_value;
		},
		// Inspector modal
		createNew: function(data) {
			if($(".inspector-modal").length) {
				return;
			}

			let modal = '<div class="inspector-modal">';
					modal += '<h4>' + data.title + " <div class='close' onclick='inspector.destroyModal()'><i class='ion ion-close'></i></div></h4>";
					modal += '<div class="inspector-group-inner">';
					modal += '</div>';
					modal += '</div>';

			modal = $(modal);

			let left = selector.inspector.offset().left + selector.inspector.outerWidth() + 10,
					top = selector.inspector.offset().top;

			modal.css({
				left: left,
				top: top
			});

			selector.inspector.after(modal);
			modal.draggable({
				handle: '>h4',
				snap: '.editor-draggable-element, .inspector',
				cursor: 'move',
				containment: '.main'
			});
			modal.show();
			inspector_modal = modal;

			let create_new = inspector.addModalGroup('Create New', 'create-new');
			data.data.pattern.forEach((item) => {
				create_new.append($("<div/>", {
					class: 'inspector-control-group'
				})
				.append($("<label/>", {
					html: item.display_name
				}))
				.append($("<div/>", {
					class: 'inspector-control'
				})
				.append($("<input/>", {
					class: 'inspector-input create-new-option-input',
					id: 'create_new_option_' + item.name
				}))));
			});
			create_new.append($("<button/>", {
				class: 'btn btn-primary btn-block',
				html: 'Create',
			})
			.click(function() {
				inspector.addOption(data.data.pattern, data.data);
			}));

			$(".inspector-modal .inspector-group-inner").niceScroll({
				cursoropacitymin: .3
			});
		},
		addOption: function(pattern, data, stored) {
			let list = $("#inspector-modal-group-list"); 
			if(!list.length) {
				list = inspector.addModalGroup('List', 'list');

				let create_header = $("<div/>", {
					class: 'row'
				});
				list.append(create_header);
				pattern.forEach((item) => {
					create_header.append($("<div/>", {
						class: 'col-md-4 text-bold',
						html: item.display_name
					}));
				});
				create_header.append($("<div/>", {
					class: 'col-md-4 text-bold',
					html: 'Action'
				}));
			}


			let add_item = function(index) {
				let create_item = $("<div/>", {
					id: 'option_list_' + count_list,
					class: 'row option-list'
				});
				pattern.forEach((item) => {
					create_item.append($("<div/>", {
						class: 'col-md-4 option',
						"data-name": item.name,
						html: (stored ? stored[index][item.name] : $("#create_new_option_" + item.name).val())
					}));

					if(!stored)
						$("#create_new_option_" + item.name).val("");
				});
	
				create_item.append($("<div/>", {
					class: 'col-md-4'
				})
				.append($("<button/>", {
						class: 'btn btn-xs btn-danger',
						html: '<i class="ion ion-close"></i>'
					}).click(function() {
						let clone = data.clone;

						$(this).parent().parent().find('.option').each(function() {
							let __this = $(this);
							clone = clone.replace('{' + __this.data('name') + '}', __this.html());
						});

						let _html = selected_element.html();
						_html = _html.replace(clone, "");
						selected_element.html(_html);

						$(this).parent().parent().remove();

						if(list.find('.option-list').length < 1) {
							list.remove();
						}
					})));
	
				count_list++;
				list.sortable({
					items: '.option-list',
					cursor: 'move',
					update: function() {
						inspector.updateOptionHtml(data);
					}
				});
				list.append(create_item);
			}

			if(stored) {
				stored.forEach((opt, index) => {
					add_item(index);
				});
			}else{
					add_item();
			}

			inspector.updateOptionHtml(data);
		},
		updateOptionList: function(data) {
			let options = selected_element.attr('data-editor-options');
			
			if(options) {
				options = JSON.parse(options);
				inspector.addOption(data.pattern, data, options);
			}

		},
		updateOptionHtml: function(data) {
			_selected_element = selected_element;
			if(data.find == 'select') {
				selected_element.find('select').html("");
			}else{
				selected_element.html($(selected_element_object.html).html());
			}
			selected_element = (data.find !== undefined ? selected_element.find(data.find) : selected_element);

			let _data = [];
			$('.row.option-list').each(function(i) {
				let _this = $(this),
						clone = data.clone;

				let obj = {};
				_this.find('.option').each(function() {
					let __this = $(this);
					clone = clone.replace('{' + __this.data('name') + '}', __this.html());
					obj[__this.data('name')] = __this.html();
				});
				_data.push(obj);

				selected_element[data.selector]($(clone));
			});
			selected_element = _selected_element;
			selected_element.attr('data-editor-options', JSON.stringify(_data));

			source.update();
		},
		addModalGroup: function(title, id) {
			let create_group = $("<div/>", {
				id: 'inspector-modal-group-' + id,
				class: 'inspector-group',
				html: '<h5>' + title + '</h5>'
			});
			inspector_modal.find(".inspector-group-inner").append(create_group);
			return create_group;
		},
		destroyModal: function() {
			if($(".inspector-modal").length)
				inspector_modal.remove();
		},
		// End inspector modal
		init: function() {
			selector.inspector.show();
			
			selector.inspector.draggable({
				handle: '>h4',
				snap: '.editor-draggable-element',
				cursor: 'move',
				containment: '.main'
			});

			let top = event.clientY + $(window).scrollTop(),
					left = event.clientX;

			if(left + selector.inspector.outerWidth() >= $(document).outerWidth()) {
				left = left - selector.inspector.outerWidth();
			}

			selector.inspector.css({
				top: top,
				left: left
			});

			// add title
			selector.inspector.prepend("<h4>Inspector <div class='close' onclick='inspector.destroy()'><i class='ion ion-close'></i></div></h4>");
			selector.inspector.append('<div class="inspector-group-inner"></div>');

			// add group info
			inspector.addGroup('Info', 'info');

			selector.inspector.find('.inspector-group-inner').niceScroll({
				cursoropacitymin: .3
			});

			$(document).keydown(function(e) {
				if(e.keyCode == 46) {
					inspector.removeElement();
				}
				else if(e.keyCode == 27) {
					inspector.destroy();
				}
			});
		},
		run: function() {
			if(!editor_area.isPreview()) {
				inspector.reset();

				let selected_element_editable = selected_element_object.editable;

				inspector.init();
				inspector.addItem("info", ["Selected Element", selected_element_object.display_name]);

				if(typeof selected_element_editable == 'object') {
					selected_element_editable.forEach((item) => {
						inspector.addGroup(item.display_name, item.name);

						if(item.type == 'select') {
							item.options.forEach((opt) => {
								inspector.addItem(item.name, [opt.display_name, inspector.createSelect(item, opt, function(e) {
									let value = $(e.target).find("option:selected").val();
									inspector.editable(value, item, opt);
								})]);
							});						
						}else if(item.type == 'input') {
							inspector.addItem(item.name, [item.display_name, inspector.createInput(item, function(e) {
								let value = $(e.target).val();
								inspector.editable(value, item);
							})]);
						}else if(item.type == 'addmore') {
							inspector.addItem(item.name, [item.display_name, inspector.createButton('Manage', {
								class:'btn btn-primary btn-sm btn-block'
							}, function(e) {
								inspector.createNew({
									title: item.display_name,
									data: item
								});
								inspector.updateOptionList(item);
							})]);
						}
					});
				}

				inspector.addGroup('Danger Area', 'danger-area');
				inspector.addBlock('danger-area',  inspector.createButton('Delete Element', {
					class: 'btn btn-danger btn-block'
				}, function() {
					inspector.removeElement();
				}));

				// initialization BS plugin
				bs_plugin();
			}
		},
		destroy: function() {
			inspector.reset();
			inspector.destroyModal();
			selector.inspector.hide();
			$('.editor-draggable-element').removeClass("has-focused");
		}
	}

	$("#module-setting").on("click", function() {
		let get_setting = localStorage.getItem("_starterkit_module_setting");
		if(get_setting) {
			get_setting = JSON.parse(get_setting);
		}

		let name = (get_setting.name ? get_setting.name : ""),
				display_name = (get_setting.display_name ? get_setting.display_name : "");

		bsModal.create({
			title: '<i class="ion ion-gear-b"></i> Module Setting',
			body: '<div class="form-group"><label>Module Name</label><input type="text" class="form-control" name="module_setting_name" value="'+name+'" placeholder="e.g: my_module"><div class="help-text">An unique name, use _ instead of space</div></div><div class="form-group"><label>Module Display Name</label><input type="text" value="'+display_name+'" class="form-control" placeholder="My Module" name="module_setting_display_name"></div>',
			buttons: [
				{
					text: 'Save Setting',
					class: "btn btn-primary",
					handler: function(b) {
						let name = b.find(".modal-body [name='module_setting_name']").val(),
								display_name = b.find(".modal-body [name='module_setting_display_name']").val();

						let setting = {
							name: name,
							display_name: display_name
						}
						localStorage.setItem("_starterkit_module_setting", JSON.stringify(setting));
						bsModal.hide();
					}
				}
			]
		})
	});

	$("#module-export").on("click", function() {
		let _get_saved_layout = localStorage.getItem("_starterkit_module_layout"),
				_get_saved_setting = localStorage.getItem("_starterkit_module_setting"),
				_info = {
					domain: document.location.href,
					date: new Date().toString()
				};
		_info = JSON.stringify(_info);
		let __get_saved_setting = JSON.parse(_get_saved_setting);

		var zip = new JSZip();
		zip.file(__get_saved_setting.name + ".setting", _get_saved_setting);
		zip.file(__get_saved_setting.name + ".layout", _get_saved_layout);
		zip.file(__get_saved_setting.name + ".info", _info);
		zip.generateAsync({type:"blob"})
		.then(function(content) {
		    saveAs(content, __get_saved_setting.name + ".starterkit");
		});
	});

	$("#module-import").on("click", function() {
		bsModal.create({
			title: '<i class="ion ion-ios-upload-outline"></i> Import Layout',
			body: '<div class="form-group"><label>Select file</label><input type="file" id="module-import-file" class="form-control"><div class="help-text">Select the <code>.starterkit</code> file</div></div>',
			buttons: [
				{
					text: 'Import',
					class: 'btn btn-primary',
					handler: function() {
				    function handleFile(f) {
			        JSZip.loadAsync(f)
			        .then(function(zip) {
			            zip.forEach(function (relativePath, zipEntry) {
			            	let extension = zipEntry.name.split("."),
			            			_ex_length = extension.length;
			            			extension = extension[_ex_length - 1];
			            	zip.file(relativePath).async("text").then(function(data) {
			            		if(data) {
			            			if(extension == 'setting') {
			            				localStorage.setItem("_starterkit_module_setting", data);
			            			}else if(extension == 'layout') {
			            				localStorage.setItem("_starterkit_module_layout", data);
													selector.source_area.val(data);
													source.init();
			            			}
			            			source.init();
			            		}
			            	});
			            });
			        }, function (e) {
			        	bsModal.create({
			        		title: 'Error Reading File',
			        		body: "Error reading " + f.name + ": Your file isn't <code>.starterkit</code> file or your uploaded file is broken.",
			        		buttons: [
			        			{
			        				text: 'Close',
			        				role: "close",
			        				class: 'btn btn-primary',
			        			}
			        		]
			        	});
			        });
				    }

				    let evt = $("#module-import-file");
				    var files = evt[0].files;
				    for (var i = 0; i < files.length; i++) {
				        handleFile(files[i]);
				    }
					}
				},
				{
					text: 'Close',
					class: 'btn btn-default',
					handler: function(b) {
						if(is_ws) {
							welcome_screen();
						}else{
							bsModal.hide();
						}
					}
				}
			]
		})
	});

	$("#module-generate").on("click", function() {
		let _saved_layout = localStorage.getItem("_starterkit_module_layout"),
				_saved_setting = localStorage.getItem("_starterkit_module_setting"),
				_html = json2html(JSON.parse(_saved_layout));

				console.log($(_html).find("button[type='submit']"))
		if($(_html).find("button[type='submit']").length == 0) {
			bsModal.create({
				title: 'Missing Element',
				body: 'You don\'t have a submit button',
				buttons: [
					{
						text: 'Close',
						class: 'btn btn-primary',
						role: 'close'
					}
				]
			});
			return;
		}else if($(_html).find(".form-group").length == 0) {
			bsModal.create({
				title: 'Missing Element',
				body: 'You don\'t have a field',
				buttons: [
					{
						text: 'Close',
						class: 'btn btn-primary',
						role: 'close'
					}
				]
			});
			return;
		}

		let _body = '';
				_body += '<div class="row">';
				_body += '<div class="col-md-4">';
				_body += '<div class="form-group">';
				_body += '<label>Name</label>';
				_body += '<input type="text" class="form-control" value="Name">';
				_body += '</div>';
				_body += '</div>';
				_body += '<div class="col-md-4">';
				_body += '<div class="form-group">';
				_body += '<label>Display Name</label>';
				_body += '<input type="text" class="form-control" value="Name">';
				_body += '</div>';
				_body += '</div>';
				_body += '<div class="col-md-4">';
				_body += '<div class="form-group">';
				_body += '<label>Type</label>';
				_body += '<input type="text" class="form-control" value="Name">';
				_body += '</div>';
				_body += '</div>';
				_body += '</div>';
		bsModal.create({
			title: 'Module Generate',
			body: _body,
			class: 'modal-lg',
			buttons: [
				{
					text: 'Generate',
					class: 'btn btn-primary',
					handler: function(b, button) {
						let _saved_fields = [];
						$(_html).find('.form-group').each(function(i) {
							_saved_fields[i] = {
								name: $(this).find(":input").attr('name'),
								display_name: $(this).find("label").html(),
								required: optional($(this).find(":input").attr('required')),
								max: optional($(this).find(":input").attr('max')),
								min: optional($(this).find(":input").attr('min')),
								max_filesize: optional($(this).find(":input").attr('max-filesize'))
							}
						});

						_saved_layout = generate_html(_html);
						let _button_text = button.html(),
								_data_to_send = {
									layout: _saved_layout,
									setting: _saved_setting,
									fields: _saved_fields
								};

						$.ajax({
							url: request_url.generate,
							data: _data_to_send,
							headers: {
								'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
							},
							type: 'post',
							dataType: 'json',
							error: function(xhr) {
								console.log(xhr)
							},
							beforeSend: function() {
								button.html('Generating module ...');
								button.addClass('disabled');								
							},
							complete: function() {
								button.html(_button_text);
								button.removeClass('disabled');								
							}
						})
					}
				}
			]
		})
	});

</script>
@stop