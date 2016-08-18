
        (function(){
var dojo = odojo;

var dijit = odijit;

var dojox = odojox;

dojo.declare("OfflajnMultiSelectList", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.lineHeight = 20;
    this.init();
  },

  init: function() {
    this.multiselect = dojo.byId('offlajnmultiselect' + this.name);
    if(this.joomla && !this.name.match(/zoo/)) {
      this.type = this.typeSelectorInit();
    } else if(this.name.match(/zoo/)) {
      this.type = this.ZooSelectorInit();
    }
    this.itemscontainer = dojo.create('div', {'class': 'multiselectitems', 'innerHTML': this.data[this.type]}, this.multiselect);
    if(dojo.isIE == 7) dojo.style(this.multiselect, 'width', dojo.position(this.itemscontainer).w + 10 + 'px'); //IE7 width bug
    this.getList();
    this.hidden = dojo.byId(this.name);
    this.hidden.options = this.options;
    this.hidden.listobj = this;

    this.setSize();
    dojo.connect(this.itemscontainer, 'onclick', this, 'selectItem');
    this.setSelected();
    if(this.height) {
      this.scrollbar = new OfflajnScroller({
        'extraClass': 'multi-select',
        'selectbox': this.multiselect,
        'content': this.itemscontainer,
        'scrollspeed' : 30
      });
      if(this.list.length <= this.height - 2) this.scrollbar.hideScrollBtn();
    }
  },

  getList: function() {
    this.list = dojo.query('.multiselectitem', this.itemscontainer);
    this.list.forEach(function(el, i){
      if(this.type != 'simple') {
        el.i = 0;
        if(i) {
          el.i = this.ids[this.type][i-1];
        }
      } else {
          el.i = this.ids[this.type][i];
      }
    },this);
  },

  setSize: function() {
    dojo.style(this.multiselect, {
	   'height': this.height * this.lineHeight +  'px'
	});
  },

  setSelected: function() {
    var arr = this.hidden.value.split('|');
    if ((arr.length < this.list.length-1 && arr.length != 0) || this.type == 'simple') {
      dojo.forEach(arr, function(item, i){
        this.list.forEach(function(el, j){
          if (el.i == item){
            dojo.addClass(this.list[j], 'selected');
            if(this.mode == 2)
              this.hidden.selectedIndex = el.i;
          }
        }, this);
      }, this);
    } else {
        dojo.addClass(this.list[0], 'selected');
    }
  },

  selectItem: function(e) {
    if(this.mode == 1 && e.target.i == 0){
      this.allItemSelection();
    }else{
      if(this.mode == 1 && dojo.hasClass(this.list[0], 'selected')) {
        this.list.forEach(function(el, i){
          dojo.removeClass(el, 'selected');
        },this);
        if(dojo.hasClass(e.target, 'selected')) {
          dojo.removeClass(e.target, 'selected');
        } else {
          dojo.addClass(e.target, 'selected');
        }
      }else if(this.mode == 2){
        this.list.forEach(function(el, i){
          dojo.removeClass(el, 'selected');
        },this);
        dojo.addClass(e.target, 'selected');
        this.hidden.selectedIndex = e.target.i;
      }else{
        if(dojo.hasClass(e.target, 'selected')) {
          dojo.removeClass(e.target, 'selected');
        } else {
          dojo.addClass(e.target, 'selected');
        }
      }
    }
    this.getValues(0);
  },

  allItemSelection: function() {
    this.list.forEach(function(el, i){
      dojo.removeClass(el, 'selected');
    },this);

    dojo.addClass(this.list[0], 'selected');
  },

  getValues: function(mode) {
    var val = 0;
    this.list.forEach(function(el, i){
      if (dojo.hasClass(el, 'selected') || mode == 1) {
        (val) ? val += '|' + el.i : val = el.i;
      }
    },this);
    if(val != this.hidden.value){
      this.hidden.value = val;
      //OfflajnFireEvent(this.hidden, 'change');
    }
     OfflajnFireEvent(this.hidden, 'change');
  },

  /*
  *Menutypeselector
  */

  typeSelectorInit: function() {
    var ts = this.name.replace('joomlamenutype', 'joomlamenu');
    this.typeselector = dojo.byId(ts);
    dojo.connect(this.typeselector, 'onchange', this, 'changeMenuItems');
    return this.typeselector.value;
  },

  changeMenuItems: function() {
    this.type = this.typeselector.value;
    this.itemscontainer.innerHTML = this.data[this.type];
    this.setSize();
    this.getList();
    this.hidden.value = '';
    this.scrollbar.scrollReInit();
    if(this.list.length <= this.height - 2) this.scrollbar.hideScrollBtn();
  },


  /*
  *Zoo Type Selector
  */
  
  ZooSelectorInit: function() {
    //var ts = this.name.replace('joomlamenutype', 'joomlamenu');
    var ts = "jformparamsmoduleparametersTabmenutypezooapps";
    this.typeselector = dojo.byId(ts);
    dojo.connect(this.typeselector, 'onchange', this, 'changeZooCategories');
    return this.typeselector.value;
  },

  changeZooCategories: function() {
    this.type = this.typeselector.value;
    this.itemscontainer.innerHTML = this.data[this.type];
    this.setSize();
    this.getList();
    this.hidden.value = '';
    this.scrollbar.scrollReInit();
    if(this.list.length <= this.height - 2) this.scrollbar.hideScrollBtn();
  },  


});



dojo.declare("OfflajnText", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.init();
  },


  init: function() {
    this.hidden = dojo.byId(this.id);
    dojo.connect(this.hidden, 'change', this, 'reset');

    this.input = dojo.byId(this.id+'input');
    this.switcher = dojo.byId(this.id+'unit');

    this.placeholder && dojo.attr(this.input, 'placeholder', this.placeholder.replace(/:$/, ''));

    if(this.validation == 'int'){
      dojo.connect(this.input, 'keyup', this, 'validateInt');
      this.validateInt();
    }else if(this.validation == 'float'){
      dojo.connect(this.input, 'keyup', this, 'validateFloat');
      this.validateFloat();
    }
    dojo.connect(this.input, 'onblur', this, 'change');
    if(this.switcher){
      dojo.connect(this.switcher, 'change', this, 'change');
    }else{
      if(this.attachunit != '')
        this.switcher = {'value': this.attachunit, 'noelement':true};

    }
    this.container = dojo.byId('offlajntextcontainer' + this.id);
    if(this.mode == 'increment') {
      this.arrows = dojo.query('.arrow', this.container);
      dojo.connect(this.arrows[0], 'onmousedown', dojo.hitch(this, 'mouseDown', 1));
      dojo.connect(this.arrows[1], 'onmousedown', dojo.hitch(this, 'mouseDown', -1));
    }
    dojo.connect(this.input, 'onfocus', this, dojo.hitch(this, 'setFocus', 1));
    dojo.connect(this.input, 'onblur', this, dojo.hitch(this, 'setFocus', 0));
  },

  reset: function(e){
    if(this.hidden.value != this.input.value+(this.switcher? '||'+this.switcher.value : '')){
      var v = this.hidden.value.split('||');
      this.input.value = v[0];
      if(this.switcher && this.switcher.noelement != true){
        this.switcher.value = v[1];
        OfflajnFireEvent(this.switcher, 'change');
      }
      if(e) dojo.stopEvent(e);
      OfflajnFireEvent(this.input, 'change');
    }
  },

  change: function(){
    this.hidden.value = this.input.value+(this.switcher? '||'+this.switcher.value : '');
    OfflajnFireEvent(this.hidden, 'change');
    if(this.onoff) this.hider();
  },

  setFocus: function(mode) {
    if(mode){
      dojo.addClass(this.input.parentNode, 'focus');
    } else {
      dojo.removeClass(this.input.parentNode, 'focus');
    }
  },

  hider: function() {
    if(!this.hiderdiv) {
      this.hiderdiv = dojo.create('div', {'class': 'offlajntext_hider'}, this.container);
      dojo.style(this.hiderdiv, 'width', dojo.position(this.container).w + 'px');
    }
    if(parseInt(this.switcher.value)) {
      dojo.style(this.container, 'opacity', '1');
      dojo.style(this.hiderdiv, 'display', 'none');
    } else {
      dojo.style(this.container, 'opacity', '0.5');
      dojo.style(this.hiderdiv, 'display', 'block');
    }
  },

  validateInt: function(){
    var val = parseInt(this.input.value, 10);
    if(!val) val = 0;
    this.input.value = val;
  },

  validateFloat: function(){
    var val = parseFloat(this.input.value);
    if(!val) val = 0;
    this.input.value = val;
  },

  mouseDown: function(m){
    dojo.connect(document, 'onmouseup', this, 'mouseUp');
    var f = dojo.hitch(this, 'modifyValue', m);
    f();
    this.interval = setInterval(f, 200);
  },

  mouseUp: function(){
    clearInterval(this.interval);
  },

  modifyValue: function(m) {
    var val = 0;
    if(this.validation == 'int') {
      val = parseInt(this.input.value);
    } else if(this.validation == 'float') {
      val = parseFloat(this.input.value);
    }
    val = val + m*this.scale;
    if(val < 0 && this.minus == 0) val = 0;
    this.input.value = val;
    this.change();
    OfflajnFireEvent(this.input, 'change');
  }
});

dojo.addOnLoad(function(){new OfflajnMultiSelectList({
      name: "jformparamsmoduleparametersTabmenutypejoomlacategoryid",
      height: "10",
      type: "joomlacategories",
      data: {"joomlacategories":"<div class=\"gk_hack multiselectitem\">All items<\/div><div class=\"gk_hack multiselectitem\">- Uncategorised<\/div>"},
      options: [],
      joomla: 0,
      ids: {"joomlacategories":["2"]},
      mode: 1
    });

      new OfflajnText({
        id: "jformparamsmoduleparametersTabmenutypelimit",
        validation: "",
        attachunit: "",
        mode: "",
        scale: "",
        minus: 0,
        onoff: "",
        placeholder: ""
      });
    });
      djConfig = {};})();