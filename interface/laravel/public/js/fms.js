/* Custom JS/JQuery goes here. If you've got something bigger, make a new file. */

$(document).ready(function() {
    //Makes navbar items roll open on mouseover instead of click
    $('ul.nav li.dropdown').hover(function() {
      $(this).find('.dropdown-menu').css('z-index', '+=1');
      $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
      $(this).addClass('open')
    }, function() {
      $(this).find('.dropdown-menu').css('z-index', '-=1');
      $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
      $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
      $(this).removeClass('open');

    //Enable popovers and tooltips
    $("[data-toggle='tooltip']").tooltip();
    $("[data-toggle='popover']").popover({trigger:'hover', html:true});
    });

});

//Loads and builds a chart.js line graph in the given canvas id
function loadChart(id, url, callback, size){
    $.post(url, '', function(ret){
        var ctx = $("#"+id).get(0).getContext("2d");
        var data = { labels: [], 
                 datasets: [{
                    label: "Velocity",
                    fillColor: "rgba(0,0,0,0.2)",
                    strokeColor: "rgba(0,0,0,1)",
                    pointColor: "rgba(0,0,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(0,0,0,1)",
                    data: []
                }]};

        var c = 0;
        for (t in ret){
            if (size || c % 4 == 0)
                data.labels.push(t);
            else
                data.labels.push("");
            data.datasets[0].data.push(ret[t]);
            c++;
        }

        if (size){
            ctx.canvas.width = data.labels.length*25;
            new Chart(ctx).Line(data, {pointHitDetectionRadius: 5,
                    tooltipTemplate: "<%= value %> at <%= label %>"});
        }else{
            new Chart(ctx).Line(data, {showTooltips: false, pointDot: false,
                    tooltipTemplate: "<%= value %> at <%= label %>"});
        }

        if (callback){
            callback(data.labels.length);
        }
    });
}

//Global check for stream. Set globally every time this function is called
var gTimestamp = $.now();

//Public function
function streamData(spinner, url, id){
    gTimestamp = $.now();
    doStreamData(spinner, url, id, 0, gTimestamp);
}

//Private recursive function
function doStreamData(spinner, url, id, last_id, timestamp){
  if (timestamp != gTimestamp){
    $('#'+spinner).spin(false).hide();
    $('#insert').hide();
    return;
  }

  $.get(url+(id == 0 ? '' : '/'+id)+'/'+last_id, '', function(data){
    if (timestamp == gTimestamp && data.status){
        if(data.isTileView){
          $('#'+spinner).before(data.content);
          $('#tile'+last_id).fadeIn(700);
        }
        else{
          $('#insert').before(data.content);
          $('#list'+last_id).fadeIn(700);
        }
        doStreamData(spinner, url, id, data.id, timestamp);
    } else {
        $('#'+spinner).spin(false).hide();
        $('#insert').hide();
    }
  });
}

//detect if the device is mobile
function isMobile() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

/**
 * Copyright (c)2005-2009 Matt Kruse (javascripttoolbox.com)
 * 
 * Dual licensed under the MIT and GPL licenses. 
 * This basically means you can use this code however you want for
 * free, but don't claim to have written it yourself!
 * Donations always accepted: http://www.JavascriptToolbox.com/donate/
 * 
 * Please do not link to the .js files on javascripttoolbox.com from
 * your site. Copy the files locally to your server instead.
 * 
 */
/**
 * Table.js
 * Functions for interactive Tables
 *
 * Copyright (c) 2007 Matt Kruse (javascripttoolbox.com)
 * Dual licensed under the MIT and GPL licenses. 
 *
 * @version 0.981
 *
 * @history 0.981 2007-03-19 Added Sort.numeric_comma, additional date parsing formats
 * @history 0.980 2007-03-18 Release new BETA release pending some testing. Todo: Additional docs, examples, plus jQuery plugin.
 * @history 0.959 2007-03-05 Added more "auto" functionality, couple bug fixes
 * @history 0.958 2007-02-28 Added auto functionality based on class names
 * @history 0.957 2007-02-21 Speed increases, more code cleanup, added Auto Sort functionality
 * @history 0.956 2007-02-16 Cleaned up the code and added Auto Filter functionality.
 * @history 0.950 2006-11-15 First BETA release.
 *
 * @todo Add more date format parsers
 * @todo Add style classes to colgroup tags after sorting/filtering in case the user wants to highlight the whole column
 * @todo Correct for colspans in data rows (this may slow it down)
 * @todo Fix for IE losing form control values after sort?
 */

/**
 * Sort Functions
 */
var Sort = (function(){
  var sort = {};
  // Default alpha-numeric sort
  // --------------------------
  sort.alphanumeric = function(a,b) {
    return (a==b)?0:(a<b)?-1:1;
  };
  sort['default'] = sort.alphanumeric; // IE chokes on sort.default

  // This conversion is generalized to work for either a decimal separator of , or .
  sort.numeric_converter = function(separator) {
    return function(val) {
      if (typeof(val)=="string") {
        val = parseFloat(val.replace(/^[^\d\.]*([\d., ]+).*/g,"$1").replace(new RegExp("[^\\\d"+separator+"]","g"),'').replace(/,/,'.')) || 0;
      }
      return val || 0;
    };
  };

  // Numeric Sort 
  // ------------
  sort.numeric = function(a,b) {
    return sort.numeric.convert(a)-sort.numeric.convert(b);
  };
  sort.numeric.convert = sort.numeric_converter(".");

  // Numeric Sort - comma decimal separator
  // --------------------------------------
  sort.numeric_comma = function(a,b) {
    return sort.numeric_comma.convert(a)-sort.numeric_comma.convert(b);
  };
  sort.numeric_comma.convert = sort.numeric_converter(",");

  // Case-insensitive Sort
  // ---------------------
  sort.ignorecase = function(a,b) {
    return sort.alphanumeric(sort.ignorecase.convert(a),sort.ignorecase.convert(b));
  };
  sort.ignorecase.convert = function(val) {
    if (val==null) { return ""; }
    return (""+val).toLowerCase();
  };

  // Currency Sort
  // -------------
  sort.currency = sort.numeric; // Just treat it as numeric!
  sort.currency_comma = sort.numeric_comma;

  // Date sort
  // ---------
  sort.date = function(a,b) {
    return sort.numeric(sort.date.convert(a),sort.date.convert(b));
  };
  // Convert 2-digit years to 4
  sort.date.fixYear=function(yr) {
    yr = +yr;
    if (yr<50) { yr += 2000; }
    else if (yr<100) { yr += 1900; }
    return yr;
  };
  sort.date.formats = [
    // YY[YY]-MM-DD
    { re:/(\d{2,4})-(\d{1,2})-(\d{1,2})/ , f:function(x){ return (new Date(sort.date.fixYear(x[1]),+x[2],+x[3])).getTime(); } }
    // MM/DD/YY[YY] or MM-DD-YY[YY]
    ,{ re:/(\d{1,2})[\/-](\d{1,2})[\/-](\d{2,4})/ , f:function(x){ return (new Date(sort.date.fixYear(x[3]),+x[1],+x[2])).getTime(); } }
    // Any catch-all format that new Date() can handle. This is not reliable except for long formats, for example: 31 Jan 2000 01:23:45 GMT
    ,{ re:/(.*\d{4}.*\d+:\d+\d+.*)/, f:function(x){ var d=new Date(x[1]); if(d){return d.getTime();} } }
  ];
  sort.date.convert = function(val) {
    var m,v, f = sort.date.formats;
    for (var i=0,L=f.length; i<L; i++) {
      if (m=val.match(f[i].re)) {
        v=f[i].f(m);
        if (typeof(v)!="undefined") { return v; }
      }
    }
    return 9999999999999; // So non-parsed dates will be last, not first
  };

  return sort;
})();

/**
 * The main Table namespace
 */
var Table = (function(){

  /**
   * Determine if a reference is defined
   */
  function def(o) {return (typeof o!="undefined");};

  /**
   * Determine if an object or class string contains a given class.
   */
  function hasClass(o,name) {
    return new RegExp("(^|\\s)"+name+"(\\s|$)").test(o.className);
  };

  /**
   * Add a class to an object
   */
  function addClass(o,name) {
    var c = o.className || "";
    if (def(c) && !hasClass(o,name)) {
      o.className += (c?" ":"") + name;
    }
  };

  /**
   * Remove a class from an object
   */
  function removeClass(o,name) {
    var c = o.className || "";
    o.className = c.replace(new RegExp("(^|\\s)"+name+"(\\s|$)"),"$1");
  };

  /**
   * For classes that match a given substring, return the rest
   */
  function classValue(o,prefix) {
    var c = o.className;
    if (c.match(new RegExp("(^|\\s)"+prefix+"([^ ]+)"))) {
      return RegExp.$2;
    }
    return null;
  };

  /**
   * Return true if an object is hidden.
   * This uses the "russian doll" technique to unwrap itself to the most efficient
   * function after the first pass. This avoids repeated feature detection that 
   * would always fall into the same block of code.
   */
   function isHidden(o) {
    if (window.getComputedStyle) {
      var cs = window.getComputedStyle;
      return (isHidden = function(o) {
        return 'none'==cs(o,null).getPropertyValue('display');
      })(o);
    }
    else if (window.currentStyle) {
      return(isHidden = function(o) {
        return 'none'==o.currentStyle['display'];
      })(o);
    }
    return (isHidden = function(o) {
      return 'none'==o.style['display'];
    })(o);
  };

  /**
   * Get a parent element by tag name, or the original element if it is of the tag type
   */
  function getParent(o,a,b) {
    if (o!=null && o.nodeName) {
      if (o.nodeName==a || (b && o.nodeName==b)) {
        return o;
      }
      while (o=o.parentNode) {
        if (o.nodeName && (o.nodeName==a || (b && o.nodeName==b))) {
          return o;
        }
      }
    }
    return null;
  };

  /**
   * Utility function to copy properties from one object to another
   */
  function copy(o1,o2) {
    for (var i=2;i<arguments.length; i++) {
      var a = arguments[i];
      if (def(o1[a])) {
        o2[a] = o1[a];
      }
    }
  }

  // The table object itself
  var table = {
    //Class names used in the code
    AutoStripeClassName:"table-autostripe",
    StripeClassNamePrefix:"table-stripeclass:",

    AutoSortClassName:"table-autosort",
    AutoSortColumnPrefix:"table-autosort:",
    AutoSortTitle:"Click to sort",
    SortedAscendingClassName:"table-sorted-asc",
    SortedDescendingClassName:"table-sorted-desc",
    SortableClassName:"table-sortable",
    SortableColumnPrefix:"table-sortable:",
    NoSortClassName:"table-nosort",

    AutoFilterClassName:"table-autofilter",
    FilteredClassName:"table-filtered",
    FilterableClassName:"table-filterable",
    FilteredRowcountPrefix:"table-filtered-rowcount:",
    RowcountPrefix:"table-rowcount:",
    FilterAllLabel:"Filter: All",

    AutoPageSizePrefix:"table-autopage:",
    AutoPageJumpPrefix:"table-page:",
    PageNumberPrefix:"table-page-number:",
    PageCountPrefix:"table-page-count:"
  };

  /**
   * A place to store misc table information, rather than in the table objects themselves
   */
  table.tabledata = {};

  /**
   * Resolve a table given an element reference, and make sure it has a unique ID
   */
  table.uniqueId=1;
  table.resolve = function(o,args) {
    if (o!=null && o.nodeName && o.nodeName!="TABLE") {
      o = getParent(o,"TABLE");
    }
    if (o==null) { return null; }
    if (!o.id) {
      var id = null;
      do { var id = "TABLE_"+(table.uniqueId++); } 
        while (document.getElementById(id)!=null);
      o.id = id;
    }
    this.tabledata[o.id] = this.tabledata[o.id] || {};
    if (args) {
      copy(args,this.tabledata[o.id],"stripeclass","ignorehiddenrows","useinnertext","sorttype","col","desc","page","pagesize");
    }
    return o;
  };


  /**
   * Run a function against each cell in a table header or footer, usually 
   * to add or remove css classes based on sorting, filtering, etc.
   */
  table.processTableCells = function(t, type, func, arg) {
    t = this.resolve(t);
    if (t==null) { return; }
    if (type!="TFOOT") {
      this.processCells(t.tHead, func, arg);
    }
    if (type!="THEAD") {
      this.processCells(t.tFoot, func, arg);
    }
  };

  /**
   * Internal method used to process an arbitrary collection of cells.
   * Referenced by processTableCells.
   * It's done this way to avoid getElementsByTagName() which would also return nested table cells.
   */
  table.processCells = function(section,func,arg) {
    if (section!=null) {
      if (section.rows && section.rows.length && section.rows.length>0) { 
        var rows = section.rows;
        for (var j=0,L2=rows.length; j<L2; j++) { 
          var row = rows[j];
          if (row.cells && row.cells.length && row.cells.length>0) {
            var cells = row.cells;
            for (var k=0,L3=cells.length; k<L3; k++) {
              var cellsK = cells[k];
              func.call(this,cellsK,arg);
            }
          }
        }
      }
    }
  };

  /**
   * Get the cellIndex value for a cell. This is only needed because of a Safari
   * bug that causes cellIndex to exist but always be 0.
   * Rather than feature-detecting each time it is called, the function will
   * re-write itself the first time it is called.
   */
  table.getCellIndex = function(td) {
    var tr = td.parentNode;
    var cells = tr.cells;
    if (cells && cells.length) {
      if (cells.length>1 && cells[cells.length-1].cellIndex>0) {
        // Define the new function, overwrite the one we're running now, and then run the new one
        (this.getCellIndex = function(td) {
          return td.cellIndex;
        })(td);
      }
      // Safari will always go through this slower block every time. Oh well.
      for (var i=0,L=cells.length; i<L; i++) {
        if (tr.cells[i]==td) {
          return i;
        }
      }
    }
    return 0;
  };

  /**
   * A map of node names and how to convert them into their "value" for sorting, filtering, etc.
   * These are put here so it is extensible.
   */
  table.nodeValue = {
    'INPUT':function(node) { 
      if (def(node.value) && node.type && ((node.type!="checkbox" && node.type!="radio") || node.checked)) {
        return node.value;
      }
      return "";
    },
    'SELECT':function(node) {
      if (node.selectedIndex>=0 && node.options) {
        // Sort select elements by the visible text
        return node.options[node.selectedIndex].text;
      }
      return "";
    },
    'IMG':function(node) {
      return node.name || "";
    }
  };

  /**
   * Get the text value of a cell. Only use innerText if explicitly told to, because 
   * otherwise we want to be able to handle sorting on inputs and other types
   */
  table.getCellValue = function(td,useInnerText) {
    if (useInnerText && def(td.innerText)) {
      return td.innerText;
    }
    if (!td.childNodes) { 
      return ""; 
    }
    var childNodes=td.childNodes;
    var ret = "";
    for (var i=0,L=childNodes.length; i<L; i++) {
      var node = childNodes[i];
      var type = node.nodeType;
      // In order to get realistic sort results, we need to treat some elements in a special way.
      // These behaviors are defined in the nodeValue() object, keyed by node name
      if (type==1) {
        var nname = node.nodeName;
        if (this.nodeValue[nname]) {
          ret += this.nodeValue[nname](node);
        }
        else {
          ret += this.getCellValue(node);
        }
      }
      else if (type==3) {
        if (def(node.innerText)) {
          ret += node.innerText;
        }
        else if (def(node.nodeValue)) {
          ret += node.nodeValue;
        }
      }
    }
    return ret;
  };

  /**
   * Consider colspan and rowspan values in table header cells to calculate the actual cellIndex
   * of a given cell. This is necessary because if the first cell in row 0 has a rowspan of 2, 
   * then the first cell in row 1 will have a cellIndex of 0 rather than 1, even though it really
   * starts in the second column rather than the first.
   * See: http://www.javascripttoolbox.com/temp/table_cellindex.html
   */
  table.tableHeaderIndexes = {};
  table.getActualCellIndex = function(tableCellObj) {
    if (!def(tableCellObj.cellIndex)) { return null; }
    var tableObj = getParent(tableCellObj,"TABLE");
    var cellCoordinates = tableCellObj.parentNode.rowIndex+"-"+this.getCellIndex(tableCellObj);

    // If it has already been computed, return the answer from the lookup table
    if (def(this.tableHeaderIndexes[tableObj.id])) {
      return this.tableHeaderIndexes[tableObj.id][cellCoordinates];      
    } 

    var matrix = [];
    this.tableHeaderIndexes[tableObj.id] = {};
    var thead = getParent(tableCellObj,"THEAD");
    var trs = thead.getElementsByTagName('TR');

    // Loop thru every tr and every cell in the tr, building up a 2-d array "grid" that gets
    // populated with an "x" for each space that a cell takes up. If the first cell is colspan
    // 2, it will fill in values [0] and [1] in the first array, so that the second cell will
    // find the first empty cell in the first row (which will be [2]) and know that this is
    // where it sits, rather than its internal .cellIndex value of [1].
    for (var i=0; i<trs.length; i++) {
      var cells = trs[i].cells;
      for (var j=0; j<cells.length; j++) {
        var c = cells[j];
        var rowIndex = c.parentNode.rowIndex;
        var cellId = rowIndex+"-"+this.getCellIndex(c);
        var rowSpan = c.rowSpan || 1;
        var colSpan = c.colSpan || 1;
        var firstAvailCol;
        if(!def(matrix[rowIndex])) { 
          matrix[rowIndex] = []; 
        }
        var m = matrix[rowIndex];
        // Find first available column in the first row
        for (var k=0; k<m.length+1; k++) {
          if (!def(m[k])) {
            firstAvailCol = k;
            break;
          }
        }
        this.tableHeaderIndexes[tableObj.id][cellId] = firstAvailCol;
        for (var k=rowIndex; k<rowIndex+rowSpan; k++) {
          if(!def(matrix[k])) { 
            matrix[k] = []; 
          }
          var matrixrow = matrix[k];
          for (var l=firstAvailCol; l<firstAvailCol+colSpan; l++) {
            matrixrow[l] = "x";
          }
        }
      }
    }
    // Store the map so future lookups are fast.
    return this.tableHeaderIndexes[tableObj.id][cellCoordinates];
  };

  /**
   * Sort all rows in each TBODY (tbodies are sorted independent of each other)
   */
  table.sort = function(o,args) {
    var t, tdata, sortconvert=null;
    // Allow for a simple passing of sort type as second parameter
    if (typeof(args)=="function") {
      args={sorttype:args};
    }
    args = args || {};

    // If no col is specified, deduce it from the object sent in
    if (!def(args.col)) { 
      args.col = this.getActualCellIndex(o) || 0; 
    }
    // If no sort type is specified, default to the default sort
    args.sorttype = args.sorttype || Sort['default'];

    // Resolve the table
    t = this.resolve(o,args);
    tdata = this.tabledata[t.id];

    // If we are sorting on the same column as last time, flip the sort direction
    if (def(tdata.lastcol) && tdata.lastcol==tdata.col && def(tdata.lastdesc)) {
      tdata.desc = !tdata.lastdesc;
    }
    else {
      tdata.desc = !!args.desc;
    }

    // Store the last sorted column so clicking again will reverse the sort order
    tdata.lastcol=tdata.col;
    tdata.lastdesc=!!tdata.desc;

    // If a sort conversion function exists, pre-convert cell values and then use a plain alphanumeric sort
    var sorttype = tdata.sorttype;
    if (typeof(sorttype.convert)=="function") {
      sortconvert=tdata.sorttype.convert;
      sorttype=Sort.alphanumeric;
    }

    // Loop through all THEADs and remove sorted class names, then re-add them for the col
    // that is being sorted
    this.processTableCells(t,"THEAD",
      function(cell) {
        if (hasClass(cell,this.SortableClassName)) {
          removeClass(cell,this.SortedAscendingClassName);
          removeClass(cell,this.SortedDescendingClassName);
          // If the computed colIndex of the cell equals the sorted colIndex, flag it as sorted
          if (tdata.col==table.getActualCellIndex(cell) && (classValue(cell,table.SortableClassName))) {
            addClass(cell,tdata.desc?this.SortedAscendingClassName:this.SortedDescendingClassName);
          }
        }
      }
    );

    // Sort each tbody independently
    var bodies = t.tBodies;
    if (bodies==null || bodies.length==0) { return; }

    // Define a new sort function to be called to consider descending or not
    var newSortFunc = (tdata.desc)?
      function(a,b){return sorttype(b[0],a[0]);}
      :function(a,b){return sorttype(a[0],b[0]);};

    var useinnertext=!!tdata.useinnertext;
    var col = tdata.col;

    for (var i=0,L=bodies.length; i<L; i++) {
      var tb = bodies[i], tbrows = tb.rows, rows = [];

      // Allow tbodies to request that they not be sorted
      if(!hasClass(tb,table.NoSortClassName)) {
        // Create a separate array which will store the converted values and refs to the
        // actual rows. This is the array that will be sorted.
        var cRow, cRowIndex=0;
        if (cRow=tbrows[cRowIndex]){
          // Funky loop style because it's considerably faster in IE
          do {
            if (rowCells = cRow.cells) {
              var cellValue = (col<rowCells.length)?this.getCellValue(rowCells[col],useinnertext):null;
              if (sortconvert) cellValue = sortconvert(cellValue);
              rows[cRowIndex] = [cellValue,tbrows[cRowIndex]];
            }
          } while (cRow=tbrows[++cRowIndex])
        }

        // Do the actual sorting
        rows.sort(newSortFunc);

        // Move the rows to the correctly sorted order. Appending an existing DOM object just moves it!
        cRowIndex=0;
        var displayedCount=0;
        var f=[removeClass,addClass];
        if (cRow=rows[cRowIndex]){
          do { 
            tb.appendChild(cRow[1]); 
          } while (cRow=rows[++cRowIndex])
        }
      }
    }

    // If paging is enabled on the table, then we need to re-page because the order of rows has changed!
    if (tdata.pagesize) {
      this.page(t); // This will internally do the striping
    }
    else {
      // Re-stripe if a class name was supplied
      if (tdata.stripeclass) {
        this.stripe(t,tdata.stripeclass,!!tdata.ignorehiddenrows);
      }
    }
  };

  /**
  * Apply a filter to rows in a table and hide those that do not match.
  */
  table.filter = function(o,filters,args) {
    var cell;
    args = args || {};

    var t = this.resolve(o,args);
    var tdata = this.tabledata[t.id];

    // If new filters were passed in, apply them to the table's list of filters
    if (!filters) {
      // If a null or blank value was sent in for 'filters' then that means reset the table to no filters
      tdata.filters = null;
    }
    else {
      // Allow for passing a select list in as the filter, since this is common design
      if (filters.nodeName=="SELECT" && filters.type=="select-one" && filters.selectedIndex>-1) {
        filters={ 'filter':filters.options[filters.selectedIndex].value };
      }
      // Also allow for a regular input
      if (filters.nodeName=="INPUT" && filters.type=="text") {
        filters={ 'filter':"/^"+filters.value+"/" };
      }
      // Force filters to be an array
      if (typeof(filters)=="object" && !filters.length) {
        filters = [filters];
      }

      // Convert regular expression strings to RegExp objects and function strings to function objects
      for (var i=0,L=filters.length; i<L; i++) {
        var filter = filters[i];
        if (typeof(filter.filter)=="string") {
          // If a filter string is like "/expr/" then turn it into a Regex
          if (filter.filter.match(/^\/(.*)\/$/)) {
            filter.filter = new RegExp(RegExp.$1);
            filter.filter.regex=true;
          }
          // If filter string is like "function (x) { ... }" then turn it into a function
          else if (filter.filter.match(/^function\s*\(([^\)]*)\)\s*\{(.*)}\s*$/)) {
            filter.filter = Function(RegExp.$1,RegExp.$2);
          }
        }
        // If some non-table object was passed in rather than a 'col' value, resolve it 
        // and assign it's column index to the filter if it doesn't have one. This way, 
        // passing in a cell reference or a select object etc instead of a table object 
        // will automatically set the correct column to filter.
        if (filter && !def(filter.col) && (cell=getParent(o,"TD","TH"))) {
          filter.col = this.getCellIndex(cell);
        }

        // Apply the passed-in filters to the existing list of filters for the table, removing those that have a filter of null or ""
        if ((!filter || !filter.filter) && tdata.filters) {
          delete tdata.filters[filter.col];
        }
        else {
          tdata.filters = tdata.filters || {};
          tdata.filters[filter.col] = filter.filter;
        }
      }
      // If no more filters are left, then make sure to empty out the filters object
      for (var j in tdata.filters) { var keep = true; }
      if (!keep) {
        tdata.filters = null;
      }
    }   
    // Everything's been setup, so now scrape the table rows
    return table.scrape(o);
  };

  /**
   * "Page" a table by showing only a subset of the rows
   */
  table.page = function(t,page,args) {
    args = args || {};
    if (def(page)) { args.page = page; }
    return table.scrape(t,args);
  };

  /**
   * Jump forward or back any number of pages
   */
  table.pageJump = function(t,count,args) {
    t = this.resolve(t,args);
    return this.page(t,(table.tabledata[t.id].page||0)+count,args);
  };

  /**
   * Go to the next page of a paged table
   */ 
  table.pageNext = function(t,args) {
    return this.pageJump(t,1,args);
  };

  /**
   * Go to the previous page of a paged table
   */ 
  table.pagePrevious = function(t,args) {
    return this.pageJump(t,-1,args);
  };

  /**
  * Scrape a table to either hide or show each row based on filters and paging
  */
  table.scrape = function(o,args) {
    var col,cell,filterList,filterReset=false,filter;
    var page,pagesize,pagestart,pageend;
    var unfilteredrows=[],unfilteredrowcount=0,totalrows=0;
    var t,tdata,row,hideRow;
    args = args || {};

    // Resolve the table object
    t = this.resolve(o,args);
    tdata = this.tabledata[t.id];

    // Setup for Paging
    var page = tdata.page;
    if (def(page)) {
      // Don't let the page go before the beginning
      if (page<0) { tdata.page=page=0; }
      pagesize = tdata.pagesize || 25; // 25=arbitrary default
      pagestart = page*pagesize+1;
      pageend = pagestart + pagesize - 1;
    }

    // Scrape each row of each tbody
    var bodies = t.tBodies;
    if (bodies==null || bodies.length==0) { return; }
    for (var i=0,L=bodies.length; i<L; i++) {
      var tb = bodies[i];
      for (var j=0,L2=tb.rows.length; j<L2; j++) {
        row = tb.rows[j];
        hideRow = false;

        // Test if filters will hide the row
        if (tdata.filters && row.cells) {
          var cells = row.cells;
          var cellsLength = cells.length;
          // Test each filter
          for (col in tdata.filters) {
            if (!hideRow) {
              filter = tdata.filters[col];
              if (filter && col<cellsLength) {
                var val = this.getCellValue(cells[col]);
                if (filter.regex && val.search) {
                  hideRow=(val.search(filter)<0);
                }
                else if (typeof(filter)=="function") {
                  hideRow=!filter(val,cells[col]);
                }
                else {
                  hideRow = (val!=filter);
                }
              }
            }
          }
        }

        // Keep track of the total rows scanned and the total runs _not_ filtered out
        totalrows++;
        if (!hideRow) {
          unfilteredrowcount++;
          if (def(page)) {
            // Temporarily keep an array of unfiltered rows in case the page we're on goes past
            // the last page and we need to back up. Don't want to filter again!
            unfilteredrows.push(row);
            if (unfilteredrowcount<pagestart || unfilteredrowcount>pageend) {
              hideRow = true;
            }
          }
        }

        row.style.display = hideRow?"none":"";
      }
    }

    if (def(page)) {
      // Check to see if filtering has put us past the requested page index. If it has, 
      // then go back to the last page and show it.
      if (pagestart>=unfilteredrowcount) {
        pagestart = unfilteredrowcount-(unfilteredrowcount%pagesize);
        tdata.page = page = pagestart/pagesize;
        for (var i=pagestart,L=unfilteredrows.length; i<L; i++) {
          unfilteredrows[i].style.display="";
        }
      }
    }

    // Loop through all THEADs and add/remove filtered class names
    this.processTableCells(t,"THEAD",
      function(c) {
        ((tdata.filters && def(tdata.filters[table.getCellIndex(c)]) && hasClass(c,table.FilterableClassName))?addClass:removeClass)(c,table.FilteredClassName);
      }
    );

    // Stripe the table if necessary
    if (tdata.stripeclass) {
      this.stripe(t);
    }

    // Calculate some values to be returned for info and updating purposes
    var pagecount = Math.floor(unfilteredrowcount/pagesize)+1;
    if (def(page)) {
      // Update the page number/total containers if they exist
      if (tdata.container_number) {
        tdata.container_number.innerHTML = page+1;
      }
      if (tdata.container_count) {
        tdata.container_count.innerHTML = pagecount;
      }
    }

    // Update the row count containers if they exist
    if (tdata.container_filtered_count) {
      tdata.container_filtered_count.innerHTML = unfilteredrowcount;
    }
    if (tdata.container_all_count) {
      tdata.container_all_count.innerHTML = totalrows;
    }
    return { 'data':tdata, 'unfilteredcount':unfilteredrowcount, 'total':totalrows, 'pagecount':pagecount, 'page':page, 'pagesize':pagesize };
  };

  /**
   * Shade alternate rows, aka Stripe the table.
   */
  table.stripe = function(t,className,args) { 
    args = args || {};
    args.stripeclass = className;

    t = this.resolve(t,args);
    var tdata = this.tabledata[t.id];

    var bodies = t.tBodies;
    if (bodies==null || bodies.length==0) { 
      return; 
    }

    className = tdata.stripeclass;
    // Cache a shorter, quicker reference to either the remove or add class methods
    var f=[removeClass,addClass];
    for (var i=0,L=bodies.length; i<L; i++) {
      var tb = bodies[i], tbrows = tb.rows, cRowIndex=0, cRow, displayedCount=0;
      if (cRow=tbrows[cRowIndex]){
        // The ignorehiddenrows test is pulled out of the loop for a slight speed increase.
        // Makes a bigger difference in FF than in IE.
        // In this case, speed always wins over brevity!
        if (tdata.ignoreHiddenRows) {
          do {
            f[displayedCount++%2](cRow,className);
          } while (cRow=tbrows[++cRowIndex])
        }
        else {
          do {
            if (!isHidden(cRow)) {
              f[displayedCount++%2](cRow,className);
            }
          } while (cRow=tbrows[++cRowIndex])
        }
      }
    }
  };

  /**
   * Build up a list of unique values in a table column
   */
  table.getUniqueColValues = function(t,col) {
    var values={}, bodies = this.resolve(t).tBodies;
    for (var i=0,L=bodies.length; i<L; i++) {
      var tbody = bodies[i];
      for (var r=0,L2=tbody.rows.length; r<L2; r++) {
        values[this.getCellValue(tbody.rows[r].cells[col])] = true;
      }
    }
    var valArray = [];
    for (var val in values) {
      valArray.push(val);
    }
    return valArray.sort();
  };

  /**
   * Scan the document on load and add sorting, filtering, paging etc ability automatically
   * based on existence of class names on the table and cells.
   */
  table.auto = function(args) {
    var cells = [], tables = document.getElementsByTagName("TABLE");
    var val,tdata;
    if (tables!=null) {
      for (var i=0,L=tables.length; i<L; i++) {
        var t = table.resolve(tables[i]);
        tdata = table.tabledata[t.id];
        if (val=classValue(t,table.StripeClassNamePrefix)) {
          tdata.stripeclass=val;
        }
        // Do auto-filter if necessary
        if (hasClass(t,table.AutoFilterClassName)) {
          table.autofilter(t);
        }
        // Do auto-page if necessary
        if (val = classValue(t,table.AutoPageSizePrefix)) {
          table.autopage(t,{'pagesize':+val});
        }
        // Do auto-sort if necessary
        if ((val = classValue(t,table.AutoSortColumnPrefix)) || (hasClass(t,table.AutoSortClassName))) {
          table.autosort(t,{'col':(val==null)?null:+val});
        }
        // Do auto-stripe if necessary
        if (tdata.stripeclass && hasClass(t,table.AutoStripeClassName)) {
          table.stripe(t);
        }
      }
    }
  };

  /**
   * Add sorting functionality to a table header cell
   */
  table.autosort = function(t,args) {
    t = this.resolve(t,args);
    var tdata = this.tabledata[t.id];
    this.processTableCells(t, "THEAD", function(c) {
      var type = classValue(c,table.SortableColumnPrefix);
      if (type!=null) {
        type = type || "default";
        c.title =c.title || table.AutoSortTitle;
        addClass(c,table.SortableClassName);
        c.onclick = Function("","Table.sort(this,{'sorttype':Sort['"+type+"']})");
        // If we are going to auto sort on a column, we need to keep track of what kind of sort it will be
        if (args.col!=null) {
          if (args.col==table.getActualCellIndex(c)) {
            tdata.sorttype=Sort['"+type+"'];
          }
        }
      }
    } );
    if (args.col!=null) {
      table.sort(t,args);
    }
  };

  /**
   * Add paging functionality to a table 
   */
  table.autopage = function(t,args) {
    t = this.resolve(t,args);
    var tdata = this.tabledata[t.id];
    if (tdata.pagesize) {
      this.processTableCells(t, "THEAD,TFOOT", function(c) {
        var type = classValue(c,table.AutoPageJumpPrefix);
        if (type=="next") { type = 1; }
        else if (type=="previous") { type = -1; }
        if (type!=null) {
          c.onclick = Function("","Table.pageJump(this,"+type+")");
        }
      } );
      if (val = classValue(t,table.PageNumberPrefix)) {
        tdata.container_number = document.getElementById(val);
      }
      if (val = classValue(t,table.PageCountPrefix)) {
        tdata.container_count = document.getElementById(val);
      }
      return table.page(t,0,args);
    }
  };

  /**
   * A util function to cancel bubbling of clicks on filter dropdowns
   */
  table.cancelBubble = function(e) {
    e = e || window.event;
    if (typeof(e.stopPropagation)=="function") { e.stopPropagation(); } 
    if (def(e.cancelBubble)) { e.cancelBubble = true; }
  };

  /**
   * Auto-filter a table
   */
  table.autofilter = function(t,args) {
    args = args || {};
    t = this.resolve(t,args);
    var tdata = this.tabledata[t.id],val;
    table.processTableCells(t, "THEAD", function(cell) {
      if (hasClass(cell,table.FilterableClassName)) {
        var cellIndex = table.getCellIndex(cell);
        var colValues = table.getUniqueColValues(t,cellIndex);
        if (colValues.length>0) {
          if (typeof(args.insert)=="function") {
            func.insert(cell,colValues);
          }
          else {
            var sel = '<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="'+table.AutoFilterClassName+'"><option value="">'+table.FilterAllLabel+'</option>';
            for (var i=0; i<colValues.length; i++) {
              sel += '<option value="'+colValues[i]+'">'+colValues[i]+'</option>';
            }
            sel += '</select>';
            cell.innerHTML += "<br>"+sel;
          }
        }
      }
    });
    if (val = classValue(t,table.FilteredRowcountPrefix)) {
      tdata.container_filtered_count = document.getElementById(val);
    }
    if (val = classValue(t,table.RowcountPrefix)) {
      tdata.container_all_count = document.getElementById(val);
    }
  };

  /**
   * Attach the auto event so it happens on load.
   * use jQuery's ready() function if available
   */
  if (typeof(jQuery)!="undefined") {
    jQuery(table.auto);
  }
  else if (window.addEventListener) {
    window.addEventListener( "load", table.auto, false );
  }
  else if (window.attachEvent) {
    window.attachEvent( "onload", table.auto );
  }

  return table;
})();
