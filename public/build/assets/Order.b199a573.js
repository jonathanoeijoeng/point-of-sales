import{K as b,m as v,Y as x,z as a,d as y,q as w,X as m,o as n,c as C,w as S,a as e,t as c,g as k,h as B,b as d,e as f,i as O,n as j,F as V}from"./app.26abd7f4.js";import{_ as $}from"./AppLayout.5160a2b8.js";import M from"./Order.7ed93fc8.js";import Y from"./Cart.66852c19.js";import{_ as I}from"./Textinput.ca21cff9.js";import{r as l}from"./index.01694b03.js";import{d as N}from"./dayjs.min.56cdf306.js";import"./_plugin-vue_export-helper.cdc0426e.js";import"./CheckoutButton.1622d63a.js";import"./DangerButton.488bf29e.js";import"./PrimaryButton.9f82891a.js";import"./DialogModal.005b196a.js";import"./InputLabel.b208b1b0.js";import"./TextInput.877140f0.js";const D={class:"grid grid-cols-12 relative"},F={class:"py-12 bg-slate-100 xl:col-span-8 lg:col-span-7 overflow-y-auto h-screen"},T={class:"max-w-full mx-auto sm:px-6 lg:px-8"},z={class:"flex justify-between gap-6"},E={class:"text-2xl font-bold"},L={class:"text-slate-500 text-sm mt-2"},P={class:"font-semibold"},q={class:"grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 gap-8 lg:gap-3 mt-12"},H=["value","onClick"],K={class:"overflow-hidden"},R={class:"px-4 py-12 xl:col-span-4 lg:col-span-5 overflow-y-auto h-screen"},le={__name:"Order",props:{foods:{type:Object},categories:{type:Object},carts:{type:Object},table_id:{type:String}},setup(p){const r=p,t=b({search:"",category:""});v(t,o=>{a.Inertia.get(l("order"),{filters:o},{preserveState:!0,preserveScroll:!0,replace:!0})});const _=()=>{t.search="",t.category=""};r.table_id==null&&x.fire({title:"Error",text:"No table number found!",icon:"error",allowOutsideClick:!1,showCancelButton:!1,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Choose table!"}).then(o=>{o.isConfirmed&&a.Inertia.visit(l("table"))});const u=y(r.table_id);return w(()=>{new m("ff94d45ed44d71633a8d",{cluster:"ap1"}).subscribe("order-processed").bind("OrderProcessed",function(g){a.Inertia.get(l("order"),{table_id:u.value},{preserveState:!0,preserveScroll:!0,replace:!0})}),new m("ff94d45ed44d71633a8d",{cluster:"ap1"}).subscribe("order-done").bind("OrderDone",function(g){a.Inertia.get(l("order"),{table_id:u.value},{preserveState:!0,preserveScroll:!0,replace:!0})})}),(o,i)=>(n(),C($,{title:"Order List"},{default:S(()=>[e("div",D,[e("div",F,[e("div",T,[e("div",z,[e("div",null,[e("p",E," Hi, "+c(o.$page.props.user.name),1),e("p",L,[k(" Today is "),e("span",P,c(B(N)().format("dddd, D MMMM YYYY")),1)])]),e("div",null,[d(I,{type:"text",placeholder:"Search here..",class:"w-64",modelValue:t.search,"onUpdate:modelValue":i[0]||(i[0]=s=>t.search=s)},null,8,["modelValue"])])]),e("div",q,[(n(!0),f(V,null,O(r.categories,s=>(n(),f("div",null,[e("button",{value:s.name,class:j(["bg-white border border-slate-300 shadow-md rounded-lg py-2 px-8 flex justify-evenly items-center gap-4 cursor-pointer hover:bg-orange-600 hover:text-white hover:font-bold transition w-full uppercase tracking-wider",{"bg-orange-600 text-white":t.category==s.id}]),onClick:h=>t.category=s.id},c(s.name),11,H)]))),256))]),e("div",{class:"mt-6"},[e("p",{class:"text-sm text-slate-500 hover:text-slate-800 hover:underline cursor-pointer",onClick:_}," Reset Filter ")]),e("div",K,[d(M,{foods:r.foods,categories:p.categories,filter:t.category,table_id:r.table_id},null,8,["foods","categories","filter","table_id"])])])]),e("div",R,[d(Y,{carts:r.carts,table_id:r.table_id},null,8,["carts","table_id"])])])]),_:1}))}};export{le as default};