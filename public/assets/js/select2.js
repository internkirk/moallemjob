$(function() {
	
	$('.select2').select2({
		placeholder: 'Choose one',
		searchInputPlaceholder: 'Search',
		minimumResultsForSearch: Infinity,
		width: '100%'
	});

	$('.select2-with-search').select2({
		placeholder: 'Choose one',
		searchInputPlaceholder: 'Search',
		width: '100%'
	});

	function formatState (state) {
	  if (!state.id) { return state.text; }
	  var $state = $(
		'<span><img src="assets/plugins/flag-icon-css/flags/4x3/' +  state.element.value.toLowerCase() +
	'.svg" class="img-flag" /> ' +
	state.text +  '</span>'
	 );
	 return $state;
	};

	$(".select2-flag-search").select2({
	  templateResult: formatState,
	  templateSelection: formatState,
	   escapeMarkup: function(m) { return m; }
	});
	
});
