<template>
  <div :id="attrs.canvasId"></div>
</template>
<script>
import { Column } from "@antv/g2plot";
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
    this.antv = new Column(this.attrs.canvasId, {
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
