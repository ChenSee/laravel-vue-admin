(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{"1Lw9":function(t,e,n){"use strict";n.r(e);function r(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function a(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var s=n("ma/q"),i={props:{attrs:Object},data:function(){return{antv:null}},mounted:function(){var t=this;this.antv=new s[this.attrs.funName](this.attrs.canvasId,function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?r(Object(n),!0).forEach((function(e){a(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):r(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({data:this.attrs.data},this.attrs.config)),this.antv.render(),this.$bus.on(this.attrs.busName,(function(e){t.antv.changeData(e)}))},updated:function(){this.antv.changeData(this.attrs.data)},destroyed:function(){this.$bus.off(this.attrs.busName)}},c=n("KHd+"),o=Object(c.a)(i,(function(){var t=this.$createElement;return(this._self._c||t)("div",{attrs:{id:this.attrs.canvasId}})}),[],!1,null,null,null);e.default=o.exports}}]);