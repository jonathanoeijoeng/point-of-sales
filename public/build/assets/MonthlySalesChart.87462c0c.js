import{V as a}from"./vue3-apexcharts.common.b77dc858.js";import{o as s,e as i,b as l,h as u}from"./app.ca1f34a1.js";const p={__name:"MonthlySalesChart",props:{net_revenue_month:{type:Array},month:{type:Array}},setup(o){const t=o,r={chart:{id:"basic-bar",animations:{speed:500},dropShadow:{enabled:!0,color:"#000",top:18,left:7,blur:10,opacity:.2}},colors:["#0064ff","#FF5B00"],plotOptions:{bar:{horizontal:!1,columnWidth:"75%",endingShape:"rounded",distributed:!0,borderRadius:5}},dataLabels:{enabled:!0,style:{colors:void 0},formatter:function(e){return e.toLocaleString()}},legend:{show:!0,offsetY:8},stroke:{show:!0,curve:"smooth"},xaxis:{categories:t.month},yaxis:{title:{text:"Nett Revenue"},labels:{formatter:function(e){return"IDR "+(e/1e3).toLocaleString()+"K"}}},fill:{opacity:.7},theme:{pallete:"palette3"},title:{text:"Monthly Nett Revenue This Year",style:{fontSize:"18px",fontWeight:"bold",color:"#263238"}}},n=[{name:"Nett Revenue",data:t.net_revenue_month}];return(e,c)=>(s(),i("div",null,[l(u(a),{width:"100%",height:"450",type:"line",options:r,series:n})]))}};export{p as default};
