/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




var svgWidth = 960+120;
var svgHeight = 700;

var linechartHeight = 400;
var margin = {top: 20, right: 20+120, bottom: 30, left: 50};
    //TO DO
    
    width = svgWidth - margin.left - margin.right,
    height = linechartHeight - margin.top - margin.bottom;
var barWidth = width;
var barHeight = svgHeight - linechartHeight - margin.top - margin.bottom -100;
var brushedHeight = 100;


   /* var dataset = 
[{"date":"1-May-12","close":"58.13"},{"date":"30-Apr-12","close":"53.98"},
{"date":"27-Apr-12","close":"67.00"},{"date":"26-Apr-12","close":"89.70"},
{"date":"25-Apr-12","close":"99.00"},{"date":"24-Apr-12","close":"130.28"},
{"date":"23-Apr-12","close":"166.70"},{"date":"20-Apr-12","close":"234.98"},
{"date":"19-Apr-12","close":"345.44"},{"date":"18-Apr-12","close":"443.34"},
{"date":"17-Apr-12","close":"543.70"},{"date":"16-Apr-12","close":"580.13"},
{"date":"13-Apr-12","close":"605.23"},{"date":"12-Apr-12","close":"622.77"},
{"date":"11-Apr-12","close":"626.20"},{"date":"10-Apr-12","close":"628.44"},
{"date":"9-Apr-12","close":"636.23"},{"date":"5-Apr-12","close":"633.68"},
{"date":"4-Apr-12","close":"624.31"},{"date":"3-Apr-12","close":"629.32"},
{"date":"2-Apr-12","close":"618.63"},{"date":"30-Mar-12","close":"599.55"},
{"date":"29-Mar-12","close":"609.86"},{"date":"28-Mar-12","close":"617.62"},
{"date":"27-Mar-12","close":"614.48"},{"date":"26-Mar-12","close":"606.98"}];
*/


    
function drawChart(){
    
    var parseTime = d3.timeParse("%Y-%m-%d");
  // format the data
      dataset.forEach(function(d) {
      d.date = parseTime(d.date);
      d.close = +d.close;
  });

 
var formatDate = d3.timeFormat("%d-%b-%y");  
    // key funkcija za bind elemenata
    var key = function(d){ return d.key;};
    
    
    var svg = d3.select("body").append("svg")
            .attr("width", svgWidth)
            .attr("height", svgHeight)
            .append("g")
            .attr("transform",
              "translate(" + margin.left + "," + margin.top + ")");
    
    var xScale = d3.scaleTime()
            .domain(d3.extent(dataset, function(d) { return d.date; }))   // kod ordinal scale-a treba generirati cijelu domenu, jer ju slucajno nemamo ovaj puta
            .range([0,width]); // racuna koliko mjesta zauzima band, te koliko je spacing izmedu
    var x2 = d3.scaleTime()
            .domain(d3.extent(dataset, function(d) { return d.date; }))
            .range([0, width]);
    var yScale = d3.scaleLinear()
            .domain([0,d3.max(dataset, function(d){return d.close;})])
            .range([height,0]);
    var y2 = d3.scaleLinear()
            .domain([0,d3.max(dataset, function(d){return d.close;})])
            .range([100,0]);
    
    var xScaleBrushed = d3.scaleTime()
            .domain(d3.extent(dataset, function(d) { return d.date; }))   // kod ordinal scale-a treba generirati cijelu domenu, jer ju slucajno nemamo ovaj puta
            .range([0,width]); // racuna koliko mjesta zauzima band, te koliko je spacing izmedu

    var dataLine = d3.line()
        .x(function(d) { return xScale(d.date); })
        .y(function(d) { return yScale(d.close); });

    var dataLine2 = d3.line()
        .x(function(d) { return x2(d.date); })
        .y(function(d) { return y2(d.close); });
    
    var xAxis = d3.axisBottom(xScale);
    var xAxis2 = d3.axisBottom(x2);
    
    var brush = d3.brushX(x2)
        .on("brush", brushed);

      
    
    var focus = d3.select("svg")
            .append("g")
            .attr("class", "focus")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
    var context = d3.select("svg")
        .append("g")
        .attr("class", "context")
        .attr("transform", "translate(" + 50 + "," + 600 + ")");
    
    // clip path maskira ostatak scene
    d3.select("svg").append("defs").append("clipPath")
            .attr("id", "clip")
        .append("rect")
            .attr("width",width)
            .attr("height",height);
    // linije
    svg.append("path")
          .datum(dataset)
          .attr("class", "line")
          .attr("d", dataLine);
    context.append("path")
          .datum(dataset)
          .attr("class", "line")
          .attr("d", dataLine2);
  
    context.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + 80 + ")")
      .call(xAxis2);
      
      context.append("g")
      .attr("class", "x brush")
      .call(brush)
    .selectAll("rect")
      .attr("y", -6)
      .attr("height", 100 + 7);
  
  // dodaj nevidlive tocke za hover
    svg.selectAll("circle")
            .data(dataset)
            .enter()
            .append("circle")
            .attr("cx", function(d) { return xScale(d.date);})
            .attr("cy", function(d) { return yScale(d.close);})
            .attr("r", 6)
            .attr("fill", "steelblue")
            .attr("opacity",0)
            .on("mouseover", function(d){
                d3.select(this)
                .attr("opacity", 1);
                svg.append("g")
                .attr("id", "tooltip")
                .attr("transform", "translate(" + xScale(d.date) + ","
                    + yScale(d.close) + ")")
                .append("rect")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", 120)
                .attr("height", 70)
                .attr("fill", "white")
                .attr("stroke", "steelblue");
            svg.select("#tooltip")
                .append("text")
                .attr("x",10)
                .attr("y",15)
                .attr("text-anchor", "left")
                .attr("font-family", "sans-serif")
                .attr("font-size", "11px")
                .attr("font-weight", "bold")
                .attr("fill", "steelblue")
                .text("Datum: " + formatDate(d.date));
            svg.select("#tooltip")
                .append("text")
                .attr("x",10)
                .attr("y",35)
                .attr("text-anchor", "left")
                .attr("font-family", "sans-serif")
                .attr("font-size", "11px")
                .attr("font-weight", "bold")
                .attr("fill", "steelblue")
                .text("Cijena: " + d.close);
            })
            
            .on("mouseout", function(){
                d3.select(this)
                .attr("opacity",0);
                d3.select("#tooltip").remove();
            });
  
    // Add the X Axis
  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(xScale));

  // Add the Y Axis
  svg.append("g")
      .call(d3.axisLeft(yScale));
      
      
      
      
    // volume bar chart
      
      var barchart = d3.select("svg")
              .append("g")
              .attr("transform", "translate(" + margin.left +","+ 
              (linechartHeight + margin.top) + ")");
      
      var yBarScale = d3.scaleLinear()
            .domain([0,d3.max(dataset, function(d){return d.close;})])
            .range([barHeight, 0]);
    
      barchart.selectAll("rect")
                .data(dataset)
                .enter()
                .append("rect")
                .attr("x", function(d){ return xScale(d.date);})
                .attr("y", function(d){ return yBarScale(d.close);})
                .attr("width", 15)
                .attr("height", function(d){ return barHeight - yBarScale(d.close);})
                .attr("fill","steelblue")/*
                .on("mouseover", function(){
                    d3.select(this)
                    .attr("fill", "orange");
                })
                .on("mouseout", function(){
                    d3.select(this)
                    .transition()
                    .duration(250)
                    .attr("fill", "teal");
                })*/
                .on("mouseover", function(d){
                d3.select(this)
                .attr("opacity", 1);
                svg.append("g")
                .attr("id", "tooltip")
                .attr("transform", "translate(" + xScale(d.date) + ","
                    + yScale(d.close) + ")")
                 .append("circle")
                .attr("cx", 0)
                .attr("cy", 0)
                .attr("r", 6)
                .attr("fill", "steelblue")
            svg.select("#tooltip")
                .append("rect")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", 120)
                .attr("height", 70)
                .attr("fill", "white")
                .attr("stroke", "steelblue");
            svg.select("#tooltip")
                .append("text")
                .attr("x",10)
                .attr("y",15)
                .attr("text-anchor", "left")
                .attr("font-family", "sans-serif")
                .attr("font-size", "11px")
                .attr("font-weight", "bold")
                .attr("fill", "steelblue")
                .text("Datum: " + formatDate(d.date));
            svg.select("#tooltip")
                .append("text")
                .attr("x",10)
                .attr("y",35)
                .attr("text-anchor", "left")
                .attr("font-family", "sans-serif")
                .attr("font-size", "11px")
                .attr("font-weight", "bold")
                .attr("fill", "steelblue")
                .text("Cijena: " + d.close);
            })
            
            .on("mouseout", function(){
                d3.select("#tooltip").remove();
            });
      // date axis
      barchart.append("g")
      .attr("transform", "translate(0," + barHeight + ")")
      .call(d3.axisBottom(xScale));
    
      // volume axis
      barchart.append("g")
              .call(d3.axisLeft(yBarScale));
      
        var brushed = function(){
           // console.log(d3.brushSelection()===null ?);
          //xScale.domain(brush.empty() ? x2.domain() : brush.extent());
          focus.select(".line").attr("d", dataLine);
          d3.select(".x.axis").call(xAxis);
          
    };
      
      
      
      }

var showHover = function(){
    svg.append("text")
            .text(function(d){ return d.close; })
            .attr("x", xScale(d.date))
            .attr("y", yScale(d.close));
}

