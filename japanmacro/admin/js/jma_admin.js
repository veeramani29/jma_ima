var JmaAdmin = {

	createSubcategoryDropdown : function(select_id, isMaincategory, page,
			dv_to_insert) {
		var category_id = $('#' + String(select_id)).val();
		var noselect_val = 'parent-' + category_id;
		if (category_id > 0) {
			$('#parent_category_id').attr('value', category_id);
			var post_url = 'category_ajax.php?req_action=getSubCategories';
			$.ajax( {
						url : post_url,
						dataType : 'json',
						type : 'POST',
						data : {
							cat_id : category_id
						},
						error : function(xHr, textStatus, errorThrown) {

						},
						success : function(data) {
							if (data.status != 1) {
								if (isMaincategory == false) {
									if (page != 'addPost') {
										$('#' + dv_to_insert).html(
												"<div style='color:#0476C2'>"
														+ data.message
														+ "</div>");
									}
								} else {
									if (page != 'addPost') {
										$('#' + dv_to_insert).html(
												"<div style='color:#0476C2'>"
														+ data.message
														+ "</div>");
									}
								}
								$('#TD_select_subcategory').html();
							} else {
								var new_select_id = "select_subcategory_"
										+ category_id;
								var new_div_id = "Dv_select_subcategory_"
										+ category_id;
								var select_elm = "<div><select name='"
										+ new_select_id
										+ "' id='"
										+ new_select_id
										+ "'  class='styledselect_form_1' onchange='JmaAdmin.createSubcategoryDropdown(&quot;"
										+ new_select_id
										+ "&quot;,false,&quot;"
										+ page
										+ "&quot;,&quot;"
										+ new_div_id
										+ "&quot;)'><option value='"
										+ noselect_val
										+ "'>Select a subcategory if needed</option>";
								$.each(data.result, function(idx, subcat_row) {
									select_elm += "<option value='"
											+ subcat_row['post_category_id']
											+ "'>"
											+ subcat_row['post_category_name']
											+ "</option>";
								});
								select_elm += "</select></div><div id='"
										+ new_div_id + "'></div>";
								$('#' + dv_to_insert).html(select_elm);
							}
						}

					});
		} else if (category_id == 0) {
			$('#parent_category_id').attr('value', 0);
			$('#' + dv_to_insert).html('');
		} else {
			var parsed_parent_id = category_id.split("-");
			var select_parent_id = parsed_parent_id[1];
			$('#parent_category_id').attr('value', select_parent_id);
			$("#Dv_select_subcategory_" + select_parent_id).html('');
		}
	},

	/**
	 * @module : add Category
	 */
	AddCategory : {
		showHideLinkUrlEntry : function($selObj) {
			if ($($selObj).val() == 'L') {
				$('#Tr_placeholder-link_url').show();
				$('#Tr_placeholder-category_url').hide();
			} else {
				$('#Tr_placeholder-link_url').hide();
				$('#Tr_placeholder-category_url').show();
			}
		}

	},
	createPostsDropdown : function() {
		var category_id = $('#main_cat').val();
		if (category_id > 0) {
			var post_url = 'category_ajax.php?req_action=getAllPostForThisCategory';
			$.ajax( {
				url : post_url,
				dataType : 'json',
				type : 'POST',
				data : {
					cat_id : category_id
				},
				error : function(xHr, textStatus, errorThrown) {

				},
				success : function(data) {
					$('#select_post').html(
							"<div style='color:#0476C2'>" + data.result
									+ "</div>");
				}

			});
		} else {
			$('#select_post').html('');
		}
		this.switchSeoPageContentMethod();
	},
	switchSeoPageContentMethod : function(){
		if($('#select_selectpost').length>0){
			var post_id = $('#select_selectpost').val();
			if(post_id > 0){
				$('.existing_post').hide();
				$('#post_title').val($('#select_selectpost').find('option[value="'+post_id+'"]').text());
				this.createSlug();
			}else{
				$('.existing_post').show();
				$('#post_title').attr('value','');
			}
			
		}else{
			$('.existing_post').show();
			$('#post_title').attr('value','');
		}
	},
	convertToSlug : function(Text){
		  return Text
	        .toLowerCase()
	        .replace(/[^\w ]+/g,'')
	        .replace(/ +/g,'-');
	},
	createSlug : function(){
		var Text = $('#post_title').val();
		var slug = this.convertToSlug(Text);
		$('#post_url_slug').val(slug);
	}

};