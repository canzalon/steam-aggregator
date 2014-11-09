
//Sort Fixes
	//Case-Insensitivity
jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
    	return function( elem ) {
        	return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    	};
	});

	$.tablesorter.addParser({
      id: 'alphanum',
      is: function(s) {
        return false;
      },
      format: function(s) {
        var str = s.replace(/(\d{1,8})/g, function(a){
            return pad(a);
        });

        return str;
      },
      type: 'text'
    });

    function pad(num ){
      var s = '00000' + num;
      return s.substr(s.length-5);
    }    

////////////////// Table Sort + Filter Functions //////////////////

$(document).ready(function(){

	var pagerOptions = {
		container: $(".pager"),
		updateArrows: true,
		page: 0,
		size: 10,
		fixedHeight: false,
		removeRows: true,

		// css class names
		cssNext: '.next',
		cssPrev: '.prev',
		cssFirst: '.first',
		cssLast: '.last',
		cssGoto: '.gotoPage',

		cssPageDisplay: '.pagedisplay',
		cssPageSize: '.pagesize',
		cssDisabled: 'disabled',
		cssErrorRow: 'tablesorter-errorRow'
	};

	var $table = $('#sortTable').tablesorter({
		sortList: [[2,0]],
		headers: {
			1: {
				sorter: false
			},
			3: {
				sorter: 'alphanum'
			}
		}
	}).tablesorterPager(pagerOptions);
	


	// Filter Function
	$("#searchInput").keyup(function(){
		//split value of searchInput
		var data = this.value;
		//create jquery obejct of the rows
		var gametable = $("#gtable").find("tr");
		if(this.value == ""){
			gametable.show();
			return;
		}
		//hide all rows
		gametable.hide();

		//recursively filter the jquery object to get results
		gametable.filter(function(i, v){
			var $t = $(this);
			console.log(data);

			if($t.is(":Contains('"+data+"')")){
				return true;
			}
			return false;
		})
		//show the rows that match
		.show();
	});
});