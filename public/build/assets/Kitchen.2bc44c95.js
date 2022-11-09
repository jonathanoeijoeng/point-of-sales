import{q as b,X as g,z as r,o as e,c as n,w as i,a as t,e as a,F as v,i as C,t as o,h as m,g as l}from"./app.d3539838.js";import{_ as $}from"./AppLayout.4a9fc8b4.js";import{d as y}from"./dayjs.min.0df62b38.js";import{_ as u,a as x}from"./CheckoutButton.9ec29a77.js";import"./_plugin-vue_export-helper.cdc0426e.js";const w={class:"mx-6 mt-6 mb-12 border border-slate-300 rounded-lg"},B=t("div",{class:"text-xl p-4 font-bold uppercase tracking-wider bg-slate-300 rounded-t-lg"}," Kitchen Order List ",-1),N={class:"w-full text-left divide-y divide-slate-200 rounded-lg"},O=t("thead",null,[t("tr",{class:"bg-slate-200 font-semibold uppercase tracking-widest"},[t("th",{class:"py-3 px-4"},"Time Received"),t("th",{class:"py-3 px-4"},"Time Processed"),t("th",{class:"py-3 px-4"},"Table"),t("th",{class:"py-3 px-4"},"Name"),t("th",{class:"py-3 px-4"},"Quantity"),t("th",{class:"py-3 px-4"},"Note"),t("th",{class:"py-3 px-4"},"Action")])],-1),P={key:0,class:"divide-y divide-slate-200"},T={class:"py-3 px-4"},j={key:0,class:"py-3 px-4"},D={key:1,class:"py-3 px-4 text-center"},I={class:"py-3 px-4"},K={class:"py-3 px-4"},L={class:"py-3 px-4"},q={key:2,class:"py-3 px-4"},F={key:3,class:"py-3 px-4"},H={class:"py-3 px-4 flex gap-4"},S={key:1,class:"border border-slate-300"},V=t("tr",null,[t("td",{colspan:"7",class:"py-8 text-center border border-slate-300"},[t("div",{class:"text-xl flex justify-center"},[t("img",{src:"/img/giphy.gif",alt:""})])])],-1),z=[V],X={__name:"Kitchen",props:{orders:{type:Object}},setup(f){const p=f,_=c=>{r.Inertia.post(route("order.process",c))},h=c=>{r.Inertia.post(route("order.done",c))};return b(()=>{new g("ff94d45ed44d71633a8d",{cluster:"ap1"}).subscribe("order-sent").bind("OrderSent",function(s){r.Inertia.get(route("kitchen"))})}),(c,k)=>(e(),n($,{title:"Kitchen Order List"},{default:i(()=>[t("div",w,[B,t("div",null,[t("table",N,[O,p.orders.length>0?(e(),a("tbody",P,[(e(!0),a(v,null,C(p.orders,s=>(e(),a("tr",null,[t("td",T,o(m(y)(s.time_sent_to_kitchen).format("HH:mm:ss")),1),s.time_processed?(e(),a("td",j,o(m(y)(s.time_processed).format("hh:mm:ss")),1)):(e(),a("td",D,"-")),t("td",I,o(s.table.name),1),t("td",K,o(s.food_detail.name),1),t("td",L,o(s.quantity),1),s.notes?(e(),a("td",q,o(s.notes),1)):(e(),a("td",F,"-")),t("td",H,[s.time_processed?(e(),n(u,{key:1,class:"text-sm",onClick:d=>_(s),disabled:""},{default:i(()=>[l(" Process ")]),_:2},1032,["onClick"])):(e(),n(u,{key:0,class:"text-sm",onClick:d=>_(s)},{default:i(()=>[l(" Process ")]),_:2},1032,["onClick"])),s.time_processed?(e(),n(x,{key:2,class:"text-sm",onClick:d=>h(s)},{default:i(()=>[l(" Done ")]),_:2},1032,["onClick"])):(e(),n(x,{key:3,class:"text-sm",onClick:d=>h(s),disabled:""},{default:i(()=>[l(" Done ")]),_:2},1032,["onClick"]))])]))),256))])):(e(),a("tbody",S,z))])])])]),_:1}))}};export{X as default};