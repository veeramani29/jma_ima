d3.VirtualScroller = function() {
    var enter = null,
        update = null,
        exit = null,
        data = [],
        dataid = null,
        svg = null,
        viewport = null,
        totalRows = 0,
        position = 0,
        rowHeight = 24,
        totalHeight = 0,
        minHeight = 0,
        viewportHeight = 0,
        visibleRows = 0,
        delta = 0,
        dispatch = d3.dispatch("pageDown","pageUp");
 
    function virtualscroller(container) {

        function render(resize) {
           if (resize) {                                                                      // re-calculate height of viewport and # of visible row
                viewportHeight = parseInt(viewport.style("height"));
                visibleRows = Math.ceil(viewportHeight / rowHeight) + 1;                       // add 1 more row for extra overlap; avoids visible add/remove at top/bottom 
            }

            var scrollTop = viewport.node().scrollTop;
            totalHeight = Math.max(minHeight, (totalRows * rowHeight));
           
            svg.attr("style","font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;height:"+totalHeight + "px").attr("height", totalHeight); //By Veera
            var lastPosition = position;
            position = Math.floor(scrollTop / rowHeight);
            delta = position - lastPosition;

            scrollRenderFrame(position);
        }


        


        function scrollRenderFrame(scrollPosition) {
 
   
            //By Veera
           // $('svg g.svg-header').attr("transform","translate(0," + ((scrollPosition * rowHeight)+10) + ")");
    //$('svg g.svg-header').attr("style","transform:translate(0px," + ((scrollPosition * rowHeight)+10) + "px)"); 
       var addtrans=0;
      if(scrollPosition==0){
         addtrans=30;
      }
            container.attr("transform", "translate(0," + ((scrollPosition * rowHeight)+addtrans) + ")");   // position viewport to stay visible
            var position0 = Math.max(0, Math.min(scrollPosition, totalRows - visibleRows + 1)), // calculate positioning (use + 1 to offset 0 position vs totalRow count diff) 
                position1 = position0 + visibleRows;

            container.each(function() {  
                                                              // slice out visible rows from data and display
                var rowSelection = container.selectAll(".row")
                    .data(data.slice(position0, Math.min(position1, totalRows)), dataid);
                rowSelection.exit().call(exit).remove();
                rowSelection.enter().append("g")
                    .attr("class", "row")
                    .call(enter);
                rowSelection.order();

              container.selectAll(".row text tspan").remove(); //By Veera

               
                var rowUpdateSelection = container.selectAll(".row:not(.transitioning)");       // do not position .transitioning elements
               
                rowUpdateSelection.call(update);
           // console.log(rowSelection);
                rowUpdateSelection.each(function(d, i) {

                     if((i%2)==0){
                        var rectColor="#ddd";
                     }else{
                        var rectColor="#fff";
                     }
                      d3.select(this).selectAll('rect').attr('fill',rectColor);
                    d3.select(this).attr("transform", function(d) {
                        return "translate(0," + ((i * rowHeight)) + ")";
                    });
                });
        
            });

            if (position1 > (data.length - visibleRows)) {                                      // dispatch events 
                dispatch.pageDown({
                    delta: delta
                });
            } else if (position0 < visibleRows) {
                dispatch.pageUp({
                    delta: delta
                });
            }
        }

        virtualscroller.render = render;                                                        // make render function publicly visible 
        viewport.on("scroll.virtualscroller", render);                                          // call render on scrolling event
        render(true);                                                                           // call render() to start
    }

    virtualscroller.render = function(resize) {                                                 // placeholder function that is overridden at runtime
    
    };

    virtualscroller.data = function(_, __) {

        if (!arguments.length) return data;
        data = _;
        dataid = __;
        return virtualscroller;
    };

    virtualscroller.dataid = function(_) {

        if (!arguments.length) return dataid;
        dataid = _;
        return virtualscroller;
    };

    virtualscroller.enter = function(_) {

        if (!arguments.length) return enter;
        enter = _;
        return virtualscroller;
    };

    virtualscroller.update = function(_) {

        if (!arguments.length) return update;
        update = _;
        return virtualscroller;
    };

    virtualscroller.exit = function(_) {

        if (!arguments.length) return exit;
        exit = _;
        return virtualscroller;
    };

    virtualscroller.totalRows = function(_) {
       
        if (!arguments.length) return totalRows;
        totalRows = _;
        return virtualscroller;
    };

    virtualscroller.rowHeight = function(_) {

        if (!arguments.length) return rowHeight;
        rowHeight = +_;
        return virtualscroller;
    };

    virtualscroller.totalHeight = function(_) {
       
        if (!arguments.length) return totalHeight;
        totalHeight = +_;
        return virtualscroller;
    };

    virtualscroller.minHeight = function(_) {
        
        if (!arguments.length) return minHeight;
        minHeight = +_;
        return virtualscroller;
    };

    virtualscroller.position = function(_) {
        
        if (!arguments.length) return position;
        position = +_;
        if (viewport) {
            viewport.node().scrollTop = position;
        }
        return virtualscroller;
    };

    virtualscroller.svg = function(_) {
        
        if (!arguments.length) return svg;
        svg = _;
        return virtualscroller;
    };

    virtualscroller.viewport = function(_) {
        
        if (!arguments.length) return viewport;
        viewport = _;
        return virtualscroller;
    };

    virtualscroller.delta = function() {
         
        return delta;
    };

    d3.rebind(virtualscroller, dispatch, "on");

    return virtualscroller;
};


function svg_word_wrap(text, width) {
    
  text.each(function() {
    var text = d3.select(this),
        words = text.text().split(/\s+/).reverse(),
        word,
        line = [],
        lineNumber = 0,
        lineHeight = 1.1, // ems
        y = 10,
        dy = 0.5;
         if(words.length>1){
       var tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
         }else{
             var tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
        }
    while (word = words.pop()) {
      line.push(word);
      tspan.text(line.join(" "));
      if (tspan.node().getComputedTextLength() > width) {
        line.pop();
        tspan.text(line.join(" "));
        line = [word];
        if(words.length>1){
            tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
        }else{
            tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
        }
        
      }
    }
  });
}