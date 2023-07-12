<template>
  <div :id="attrs.canvasId"></div>
</template>
<script>
// import G2Plot from "@antv/g2plot";
const G2Plot = require("@antv/g2plot")
export default {
  props: {
    attrs: Object
  },
  data() {
    return {
      antv: null
    };
  },
  mounted() {
    this.antv = new G2Plot[this.attrs.funName](this.attrs.canvasId, {
      data: this.attrs.data,
      ...this.attrs.config
    });
    this.antv.render();
    this.$bus.on(this.attrs.busName, (data) => {
      this.antv.changeData(data);
    });
  },
  updated() {
    this.antv.changeData(this.attrs.data);
  },
  destroyed() {
    //this.antv.destory();
    this.$bus.off(this.attrs.busName);
  }
};
</script>
