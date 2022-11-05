import{z as i,o as e,c as l,w as n,a as t,e as o,F as f,i as k,t as a,h,g as d,b}from"./app.519b2f6a.js";import{_ as g}from"./AppLayout.114ae82a.js";import{d as m}from"./dayjs.min.4b436a57.js";import{_ as y,a as v}from"./CheckoutButton.af6531b3.js";import"./_plugin-vue_export-helper.cdc0426e.js";const C={class:"px-12 py-12"},$=t("h1",{class:"text-2xl font-bold uppercase tracking-wider"}," Kitchen Order List ",-1),w={class:"mt-5"},N={class:"w-full text-left divide-y divide-slate-200 rounded-lg"},T=t("thead",null,[t("tr",{class:"bg-slate-200 font-semibold uppercase tracking-widest"},[t("th",{class:"py-3 px-4"},"Time Received"),t("th",{class:"py-3 px-4"},"Time Processed"),t("th",{class:"py-3 px-4"},"Table"),t("th",{class:"py-3 px-4"},"Name"),t("th",{class:"py-3 px-4"},"Quantity"),t("th",{class:"py-3 px-4"},"Note"),t("th",{class:"py-3 px-4"},"Action")])],-1),B={key:0,class:"divide-y divide-slate-200"},D={class:"py-3 px-4"},I={key:0,class:"py-3 px-4"},K={key:1,class:"py-3 px-4 text-center"},L={class:"py-3 px-4"},O={class:"py-3 px-4"},P={class:"py-3 px-4"},V={key:2,class:"py-3 px-4"},j={key:3,class:"py-3 px-4"},A={class:"py-3 px-4 flex gap-4"},F={key:1,class:"border border-slate-300"},H=t("tr",null,[t("td",{colspan:"7",class:"py-8 text-center border border-slate-300"},[t("p",{class:"text-xl"},"All Done! Great Job!")])],-1),q=[H],S={__name:"Kitchen",props:{orders:{type:Object}},setup(x){const p=x,_=c=>{i.Inertia.post(route("order.process",c))},u=c=>{i.Inertia.post(route("order.done",c))};return setTimeout(function(){i.Inertia.get(route("kitchen"))},5e3),(c,z)=>(e(),l(g,{title:"Kitchen Order List"},{default:n(()=>[t("div",C,[$,t("div",w,[t("table",N,[T,p.orders.length>0?(e(),o("tbody",B,[(e(!0),o(f,null,k(p.orders,s=>(e(),o("tr",null,[t("td",D,a(h(m)(s.time_sent_to_kitchen).format("HH:mm:ss")),1),s.time_processed?(e(),o("td",I,a(h(m)(s.time_processed).format("hh:mm:ss")),1)):(e(),o("td",K,"-")),t("td",L,a(s.table.name),1),t("td",O,a(s.food_detail.name),1),t("td",P,a(s.quantity),1),s.notes?(e(),o("td",V,a(s.notes),1)):(e(),o("td",j,"-")),t("td",A,[s.time_processed?(e(),l(y,{key:1,class:"text-sm",onClick:r=>_(s),disabled:""},{default:n(()=>[d(" Process ")]),_:2},1032,["onClick"])):(e(),l(y,{key:0,class:"text-sm",onClick:r=>_(s)},{default:n(()=>[d(" Process ")]),_:2},1032,["onClick"])),b(v,{class:"text-sm",onClick:r=>u(s)},{default:n(()=>[d(" Done ")]),_:2},1032,["onClick"])])]))),256))])):(e(),o("tbody",F,q))])])])]),_:1}))}};export{S as default};