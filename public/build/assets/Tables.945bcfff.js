import{_ as c}from"./AppLayout.114ae82a.js";import{o as t,c as i,w as u,a as r,e as s,i as _,n as x,t as l,F as m,z as p}from"./app.519b2f6a.js";import"./_plugin-vue_export-helper.cdc0426e.js";const g={class:"mx-auto max-w-7xl mb-12"},b=r("div",{class:"max-w-full mx-auto my-8 text-2xl font-bold text-slate-700 uppercase tracking tracking-wider"}," Table List ",-1),h={class:"grid grid-cols-5 gap-8 mx-auto px-12 border border-slate-300 py-8 rounded-3xl shadow-lg"},f={class:"flex justify-evenly"},y=["onClick"],k={key:1,class:"rounded-full shadow-md text-center cursor-not-allowed p-8 bg-slate-500 text-slate-200",disabled:""},z={__name:"Tables",props:{tables:{type:Array},orders:{type:Object},carts:{type:Object}},setup(n){const a=n,d=o=>{p.Inertia.get(route("order"),{table_id:o})};return(o,v)=>(t(),i(c,null,{default:u(()=>[r("div",g,[b,r("div",h,[(t(!0),s(m,null,_(a.tables,e=>(t(),s("div",f,[e.is_available==1?(t(),s("button",{key:0,class:x(["text-green-100 bg-green-600 text-center rounded-full shadow-2xl cursor-pointer px-8 py-12 hover:bg-green-700",{"text-red-200 !bg-red-600 hover:bg-red-700":a.orders.includes(e.id)}]),onClick:w=>d(e.id)},l(e.name),11,y)):(t(),s("button",k,l(e.name),1))]))),256))])])]),_:1}))}};export{z as default};
