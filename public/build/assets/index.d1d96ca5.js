import{W as g}from"./app.d3539838.js";class l{constructor(e,t,i){var r,s;this.name=e,this.definition=t,this.bindings=(r=t.bindings)!=null?r:{},this.wheres=(s=t.wheres)!=null?s:{},this.config=i}get template(){return`${this.config.absolute?this.definition.domain?`${this.config.url.match(/^\w+:\/\//)[0]}${this.definition.domain}${this.config.port?`:${this.config.port}`:""}`:this.config.url:""}/${this.definition.uri}`.replace(/\/+$/,"")}get parameterSegments(){var e,t;return(t=(e=this.template.match(/{[^}?]+\??}/g))==null?void 0:e.map(i=>({name:i.replace(/{|\??}/g,""),required:!/\?}$/.test(i)})))!=null?t:[]}matchesUrl(e){if(!this.definition.methods.includes("GET"))return!1;const t=this.template.replace(/(\/?){([^}?]*)(\??)}/g,(n,o,h,u)=>{var f;const c=`(?<${h}>${((f=this.wheres[h])==null?void 0:f.replace(/(^\^)|(\$$)/g,""))||"[^/?]+"})`;return u?`(${o}${c})?`:`${o}${c}`}).replace(/^\w+:\/\//,""),[i,r]=e.replace(/^\w+:\/\//,"").split("?"),s=new RegExp(`^${t}/?$`).exec(i);return s?{params:s.groups,query:g.parse(r)}:!1}compile(e){const t=this.parameterSegments;return t.length?this.template.replace(/{([^}?]+)(\??)}/g,(i,r,s)=>{var n,o,h;if(!s&&[null,void 0].includes(e[r]))throw new Error(`Ziggy error: '${r}' parameter is required for route '${this.name}'.`);if(t[t.length-1].name===r&&this.wheres[r]===".*")return encodeURIComponent((n=e[r])!=null?n:"").replace(/%2F/g,"/");if(this.wheres[r]&&!new RegExp(`^${s?`(${this.wheres[r]})?`:this.wheres[r]}$`).test((o=e[r])!=null?o:""))throw new Error(`Ziggy error: '${r}' parameter does not match required format '${this.wheres[r]}' for route '${this.name}'.`);return encodeURIComponent((h=e[r])!=null?h:"")}).replace(/\/+$/,""):this.template}}class d extends String{constructor(e,t,i=!0,r){if(super(),this._config=r!=null?r:typeof Ziggy<"u"?Ziggy:globalThis==null?void 0:globalThis.Ziggy,this._config={...this._config,absolute:i},e){if(!this._config.routes[e])throw new Error(`Ziggy error: route '${e}' is not in the route list.`);this._route=new l(e,this._config.routes[e],this._config),this._params=this._parse(t)}}toString(){const e=Object.keys(this._params).filter(t=>!this._route.parameterSegments.some(({name:i})=>i===t)).filter(t=>t!=="_query").reduce((t,i)=>({...t,[i]:this._params[i]}),{});return this._route.compile(this._params)+g.stringify({...e,...this._params._query},{addQueryPrefix:!0,arrayFormat:"indices",encodeValuesOnly:!0,skipNulls:!0,encoder:(t,i)=>typeof t=="boolean"?Number(t):i(t)})}_unresolve(e){e?this._config.absolute&&e.startsWith("/")&&(e=this._location().host+e):e=this._currentUrl();let t={};const[i,r]=Object.entries(this._config.routes).find(([s,n])=>t=new l(s,n,this._config).matchesUrl(e))||[void 0,void 0];return{name:i,...t,route:r}}_currentUrl(){const{host:e,pathname:t,search:i}=this._location();return(this._config.absolute?e+t:t.replace(this._config.url.replace(/^\w*:\/\/[^/]+/,""),"").replace(/^\/+/,"/"))+i}current(e,t){const{name:i,params:r,query:s,route:n}=this._unresolve();if(!e)return i;const o=new RegExp(`^${e.replace(/\./g,"\\.").replace(/\*/g,".*")}$`).test(i);if([null,void 0].includes(t)||!o)return o;const h=new l(i,n,this._config);t=this._parse(t,h);const u={...r,...s};return Object.values(t).every(c=>!c)&&!Object.values(u).some(c=>c!==void 0)?!0:Object.entries(t).every(([c,f])=>u[c]==f)}_location(){var r,s,n,o,h,u;const{host:e="",pathname:t="",search:i=""}=typeof window<"u"?window.location:{};return{host:(s=(r=this._config.location)==null?void 0:r.host)!=null?s:e,pathname:(o=(n=this._config.location)==null?void 0:n.pathname)!=null?o:t,search:(u=(h=this._config.location)==null?void 0:h.search)!=null?u:i}}get params(){const{params:e,query:t}=this._unresolve();return{...e,...t}}has(e){return Object.keys(this._config.routes).includes(e)}_parse(e={},t=this._route){e!=null||(e={}),e=["string","number"].includes(typeof e)?[e]:e;const i=t.parameterSegments.filter(({name:r})=>!this._config.defaults[r]);return Array.isArray(e)?e=e.reduce((r,s,n)=>i[n]?{...r,[i[n].name]:s}:typeof s=="object"?{...r,...s}:{...r,[s]:""},{}):i.length===1&&!e[i[0].name]&&(e.hasOwnProperty(Object.values(t.bindings)[0])||e.hasOwnProperty("id"))&&(e={[i[0].name]:e}),{...this._defaults(t),...this._substituteBindings(e,t)}}_defaults(e){return e.parameterSegments.filter(({name:t})=>this._config.defaults[t]).reduce((t,{name:i},r)=>({...t,[i]:this._config.defaults[i]}),{})}_substituteBindings(e,{bindings:t,parameterSegments:i}){return Object.entries(e).reduce((r,[s,n])=>{if(!n||typeof n!="object"||Array.isArray(n)||!i.some(({name:o})=>o===s))return{...r,[s]:n};if(!n.hasOwnProperty(t[s]))if(n.hasOwnProperty("id"))t[s]="id";else throw new Error(`Ziggy error: object passed as '${s}' parameter is missing route model binding key '${t[s]}'.`);return{...r,[s]:n[t[s]]}},{})}valueOf(){return this.toString()}check(e){return this.has(e)}}function _(a,e,t,i){const r=new d(a,e,t,i);return a?r.toString():r}export{_ as r};