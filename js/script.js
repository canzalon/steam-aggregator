
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

	var $table = $('#myTable').tablesorter({
		sortList: [[2,0]],
		headers: {
			1: {
				sorter: false
			},
			3: {
				sorter: 'alphanum'
			}
		}
	})

	// Filter Function
	

});