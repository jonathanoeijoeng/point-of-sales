import{_ as c}from"./AppLayout.ddd35695.js";import{o as t,c as i,w as _,a,e as s,i as u,n as x,t as l,F as p,z as m}from"./app.01a317a6.js";import"./_plugin-vue_export-helper.cdc0426e.js";const g={class:"mx-auto max-w-7xl mb-12 lg:px-8"},b=a("div",{class:"max-w-full mx-auto my-8 text-2xl font-bold text-slate-700 uppercase tracking tracking-wider"}," Table List ",-1),y={class:"grid grid-cols-5 gap-8 mx-auto px-12 border border-slate-300 py-8 rounded-3xl shadow-lg"},h={class:"flex justify-evenly"},f=["onClick"],v={key:1,class:"rounded-full shadow-md text-center cursor-not-allowed p-8 bg-slate-500 text-slate-200",disabled:""},T={__name:"Tables",props:{tables:{type:Array},orders:{type:Object},carts:{type:Object}},setup(n){const r=n,d=o=>{m.Inertia.get(route("order"),{table_id:o})};return(o,k)=>(t(),i(c,null,{default:_(()=>[a("div",g,[b,a("div",y,[(t(!0),s(p,null,u(r.tables,e=>(t(),s("div",h,[e.is_available==1?(t(),s("button",{key:0,class:x(["text-green-100 bg-green-600 text-center rounded-full shadow-2xl cursor-pointer px-8 py-12 hover:bg-green-700",{"text-red-200 bg-red-600 hover:bg-red-700":r.orders.includes(e.id)}]),onClick:w=>d(e.id)},l(e.name),11,f)):(t(),s("button",v,l(e.name),1))]))),256))])])]),_:1}))}};export{T as default};
