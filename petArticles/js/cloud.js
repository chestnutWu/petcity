var currentData;
var currentPagination;
var totalPagination;
(function() {
  d3.json("data/CloudData.json",function(data){
      var fill = [ "#66B3FF","#ffbb78","#ff9896","#c5b0d5","#c49c94","#f7b6d2","#c7c7c7","#ffff00","#b0e0e6","#da70d6","#ffffff","#FF359A","#00ffff","#ffc0cb","#00bfff","#ff7575","#FFE153","#E1C4C4","#CA8EC2","#FFBB77"];
      var linear = d3.scale.linear()
                     .domain([d3.min(data,function(d){return d.size;}), d3.max(data,function(d){return d.size;})])
                     .range([17, 90]);
                     console.log(d3.min(data,function(d){return d.size;}));
                     console.log(d3.max(data,function(d){return d.size;}));
      d3.layout.cloud().size([ 700, 500 ]).words(data).padding(2).rotate(
          0).font('"微軟正黑體",Impact').fontSize(function(d) {
        return linear(d.size);
      }).on("end", draw).start();
      console.log(data);
      function draw(words) {
        d3.select("#tag") //要插入標籤雲的tag id
        .append("svg").attr("width", 700).attr("height", 500)
        .append("g").attr("transform", "translate(350,250)") //這裡的值要對應到繪圖區域的寬、高的一半，針對不同的瀏覽器要設可以使用的值，如Chrome為-webkit-transform
        .selectAll("text").data(words).enter().append("text")
        .style("font-size", function(d) {
              return linear(d.size) + "px";
            })
        .style("font-family", '"微軟正黑體",Impact')
        .style("cursor", 'pointer')
        .style("fill", function(d, i) {
          var t = i%20; 
          return fill[t];
        }).attr("text-anchor", "middle")
        .attr("transform",//跟上面的transform一樣，需依不同的瀏覽器設定對應的值
            function(d) {
              return "translate(" + [ d.x, d.y ] + ")rotate(" + d.rotate + ")";
            })
        .text(function(d) {
          return d.text;
        }).on('click', function(d) {
          
          document.getElementById('articlelist').innerHTML = "";
  
          currentPagination = 0;
          currentData = d;
          totalPagination = Math.floor((currentData.url.length-1)/5);
          showNextPagination();

        });
      }
    });}());

function showArticle(currentpage)
{   
          currentPagination = currentpage;
          document.getElementById('articlelist').innerHTML = "";   
          for(var j=currentpage*5;j<(currentpage*5+5)&&(j<currentData.url.length);j++)
          {
              d3.select("body").select(".list-group").append("a")
              .attr("href", currentData.url[j]).attr("target", "_blank").attr("class", "list-group-item list-group-item-warning").attr("style", "border-style: none;")
              // .attr("style", "border-top-style: none; border-left-style: none; border-right-style: none; border-bottom-color: #A0522D; border-bottom-width: 2px; border-bottom-style:groove;")
              .append("h5").attr("class", "list-group-item-heading")
              .text("☛"+currentData.postfrom[j]).append("h5").text("⌚:"+currentData.posttime[j])
              .append("p").attr("class", "list-group-item-text").text(""+"✎:"+currentData.postmessage[j])

          }
          d3.select("body").select("#pagination").selectAll("li").attr("class", null).attr("style", "background-color: #F6FFE6;")
          d3.select("body").select("#pagination").selectAll("li").select("a").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ;border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6; cursor:pointer;")
          d3.select("body").select("#pagination").select("#firstpage").select("a").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 5px; border-left-style: solid ; border-bottom-color: #B2A59D; border-bottom-width: 5px; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ; border-bottom-style: solid ; background-color: #F6FFE6; cursor:pointer;")
          d3.select("body").select("#pagination").select("#lastpage").select("a").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 5px; border-right-style: solid ; border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6; cursor:pointer;")
          d3.select("body").select("#pagination").select("#pagination_"+currentpage+"").attr("class", "active")
          d3.select("body").select("#pagination").select("#pagination_"+currentpage+"").select("a").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ;border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: null; cursor:pointer;")

}

function showNextPagination()
{

          document.getElementById('pagination').innerHTML = "";
          d3.select("body").select("#pagination")
              .append("li").attr("id", "firstpage").append("a").attr("onclick","firstPage()").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 5px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ; border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6;").text("第一頁")
          d3.select("body").select("#pagination")
              .append("li").append("a").attr("onclick","previousPage()").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ;border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ; border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6;").text("<<")

          for(var i=currentPagination;i<currentPagination+5 && i<=(currentData.url.length-1)/5;i++)
          {
              d3.select("body").select("#pagination")
              .append("li").attr("id","pagination_"+i).append("a").attr("onclick","showArticle("+i+")").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ;border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6;").text(i+1)
          }

          d3.select("body").select("#pagination")
              .append("li").append("a").attr("onclick","nextPage()").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 1px; border-right-style: solid ;border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6;").text(">>")
          d3.select("body").select("#pagination")
              .append("li").attr("id", "lastpage").append("a").attr("onclick","lastPage()").attr("style", "border-top-color: #B2A59D; border-top-width: 5px; border-top-style: solid ; border-left-color: #B2A59D; border-left-width: 1px; border-left-style: solid ; border-right-color: #B2A59D; border-right-width: 5px; border-right-style: solid ; border-bottom-color: #B2A59D; border-bottom-width: 5px; border-bottom-style: solid ; background-color: #F6FFE6;").text("最末頁["+(totalPagination+1)+"]")

          showArticle(currentPagination);

}

function showPreviousPagination()
{

          document.getElementById('pagination').innerHTML = "";
          d3.select("body").select("#pagination")
              .append("li").attr("id", "firstpage").append("a").attr("onclick","firstPage()").text("第一頁")
          d3.select("body").select("#pagination")
              .append("li").append("a").attr("onclick","previousPage()").text("<<")

          var pageCount;
          pageCount = currentPagination%5;

          for(var i=currentPagination-pageCount;i<=currentPagination;i++)
          {
              d3.select("body").select("#pagination")
              .append("li").attr("id","pagination_"+i).append("a").attr("onclick","showArticle("+i+")").text(i+1)
          }

          d3.select("body").select("#pagination")
              .append("li").append("a").attr("onclick","nextPage()").text(">>")
          d3.select("body").select("#pagination")
              .append("li").attr("id", "lastpage").append("a").attr("onclick","lastPage()").text("最末頁["+(totalPagination+1)+"]")

          showArticle(currentPagination);


}

function nextPage(){

  if(currentPagination<totalPagination)
  {
    currentPagination++;
    showArticle(currentPagination);
    if(currentPagination%5 == 0)
        showNextPagination();
  }
}

function previousPage(){
  if(currentPagination>0)
  {
    currentPagination--;
    showArticle(currentPagination);
    if(currentPagination%5 == 4)
        showPreviousPagination();
  }
}
function firstPage(){
    currentPagination = 0;
    showArticle(currentPagination);
    showNextPagination();
  }

function lastPage(){
    currentPagination = totalPagination;
    showArticle(currentPagination);
    showPreviousPagination();

  }

