tinymce.init({
	selector: "textarea",
	language: "ko_KR",
	branding: false,
	theme: "modern",
	width: "99.7%",
	toolbar_items_size: 'small',

	fontsize_formats: "10pt 11pt 12pt 13pt 14pt 15pt 16pt 24pt 26pt",
	lineheight_formats: "1.8em 2.0em 2.2em 2.4em 2.6em 2.8em",

	content_css: [
		"//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Noto+Sans+KR|Noto+Serif+KR",
		"../plugin/editor/tinymce/css/codepen.min.css"
	],

	font_formats: 'Roboto=Roboto,sans-serif;노토 고딕=Noto Sans KR,sans-serif;노토 명조=Noto Serif KR,sans-serif',

	menubar: false,
	plugins: [
		'directionality save autosave nonbreaking noneditable imagetools pagebreak tabfocus anchor template toc importcss',
		'contextmenu lineheight code codesample fullscreen preview charmap print help',
		'advlist autolink autoresize lists textcolor colorpicker textpattern link image media',
		'visualblocks visualchars hr insertdatetime table paste wordcount searchreplace'
	],
	toolbar: "code | visualblocks | fontselect | fontsizeselect | lineheightselect | forecolor backcolor | bold italic strikethrough | blockquote | align | outdent indent | numlist bullist | help | fullscreen",

	contextmenu_never_use_native: true,
	contextmenu: "removeformat | link | image media | hr inserttable tableprops | cell row column deletetable",

	autosave_retention: "10m",

	table_appearance_options: true,
	image_advtab: true,

	setup: function (ed) {
		ed.on('init', function () {
				this.getDoc().body.style.fontFamily = 'Roboto';
				this.getDoc().body.style.fontSize = '10pt';
		});
	},

	autoresize_overflow_padding: 10,
	autoresize_max_height: 540,

	textcolor_map: [

	"ffdf5c", "Lemon",
	"ffa022", "Amber",
	"ff3823", "Orange red",
	"ff62bf", "Pink",
	"945bc2", "Amethyst",
	"a78e80", "Mink",
	"95a5a6", "Concrete",
	"ecf0f1", "Light gray",

	"ffc717", "Yellow",
	"ff7528", "Orange",
	"d11915", "Red",
	"ec3e9d", "Hot pink",
	"53308b", "Violet",
	"7e6f69", "Ash",
	"7f8c8d", "Asbestos",
	"bdc3c7", "Gray",

	"add72a", "Lime",
	"63c856", "Fern",
	"04d1af", "Mint",
	"44b1e1", "Sky blue",
	"1984dc", "Blue",
	"5863e7", "Lapis",
	"41527d", "Aegean",
	"000000", "Balck",

	"96c10f", "Pear",
	"34b439", "Green",
	"00a88a", "Teal",
	"2e92c8", "Light blue",
	"1867c0", "Cobalt",
	"3943bb", "Indigo",
	"232f52", "Navy"

	],
	
	textpattern_patterns: [

	{start: '*', end: '*', format: 'italic'},
	{start: '**', end: '**', format: 'bold'},
	{start: '#', format: 'h1'},
	{start: '##', format: 'h2'},
	{start: '###', format: 'h3'},
	{start: '####', format: 'h4'},
	{start: '#####', format: 'h5'},
	{start: '######', format: 'h6'},
	{start: '1. ', cmd: 'InsertOrderedList'},
	{start: '* ', cmd: 'InsertUnorderedList'},
	{start: 'code ', cmd: 'codesample'},
	{start: '//brb', replacement: 'Be Right Back'}

	],

});
