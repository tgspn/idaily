      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Sistema de gerenciamento de diárias</h1>
        <p></p>
        <br/>
      <div class="row">
        <style>

  .bar {
    fill: steelblue;
  }

  .bar:hover {
    fill: brown;
  }

  .axis--x path {
    display: none;
  }

  </style>

  <svg width="530" height="450" id="gastoMensal"></svg>

  <svg width="530" height="450" id="gastousuarios"></svg>
</div>
    </div>
  <script src="https://d3js.org/d3.v4.min.js"></script>

      <script>

function renderGastoMensal(){
      var svg = d3.select("#gastoMensal"),
      margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = +svg.attr("width") - margin.left - margin.right,
      height = +svg.attr("height") - margin.top - margin.bottom;

  var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
      y = d3.scaleLinear().rangeRound([height, 0]);

  var g = svg.append("g")
      .attr("transform", "translate(" + margin.left + "," + (margin.top) + ")");

g.append("text")
.attr("y", -9)
.attr("x", '36%')
 .text("Gasto/Mês");

  d3.tsv("Home/GetTSV", function(d) {
    d.gasto = +d.gasto;
    return d;
  }, function(error, data) {
    if (error) throw error;

    x.domain(data.map(function(d) { return d.mes; }));
    y.domain([0, d3.max(data, function(d) { return d.gasto; })]);

    g.append("g")
        .attr("class", "axis axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
      ;

    g.append("g")
        .attr("class", "axis axis--y")
        .call(d3.axisLeft(y).ticks(10, "s"))
      .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "0.71em")
        .attr("text-anchor", "end")
        .text("Gastos");

    g.selectAll(".bar")
      .data(data)
      .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.mes); })
        .attr("y", function(d) { return y(d.gasto); })
        .attr("width", x.bandwidth())
        .attr("height", function(d) { return height - y(d.gasto); }) ;
  });
}

function renderGastoUsuario(){
      var svg = d3.select("#gastousuarios"),
      margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = +svg.attr("width") - margin.left - margin.right,
      height = +svg.attr("height") - margin.top - margin.bottom;

  var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
      y = d3.scaleLinear().rangeRound([height, 0]);

  var g = svg.append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  g.append("text")
   .attr("y", -9)
   .attr("x", '36%')
   .text("Gasto/Usuario");
  d3.tsv("Home/GetGastoUsuario", function(d) {
    d.gasto = +d.gasto;
    return d;
  }, function(error, data) {
    if (error) throw error;

    x.domain(data.map(function(d) { return d.usuario; }));
    y.domain([0, d3.max(data, function(d) { return d.gasto; })]);

    g.append("g")
        .attr("class", "axis axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    g.append("g")
        .attr("class", "axis axis--y")
        .call(d3.axisLeft(y).ticks(10, "s"))
      .append("text")
       .attr("transform", "rotate(-90)")
       .attr("y", 6)
       .attr("dy", "0.71em")
       .attr("text-anchor", "end")
        .text("Gastos");

    g.selectAll(".bar")
      .data(data)
      .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.usuario); })
        .attr("y", function(d) { return y(d.gasto); })
        .attr("width", x.bandwidth())
        .attr("height", function(d) { return height - y(d.gasto); });
  });
}
renderGastoMensal();
renderGastoUsuario();
      </script>
