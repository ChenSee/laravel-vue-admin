<template>
  <el-image :style="attrs.style" :class="attrs.className" :fit="attrs.fit" :lazy="attrs.lazy" :src="src"
    :scroll-container="attrs.scrollContainer" :preview-src-list="previewSrcList" />
</template>
<script>
import { getFileUrl } from "@/utils";
export default {
  props: {
    attrs: Object,
    value: {
      default: null
    },
    row: Object,
    columnValue: {
      default: null
    }
  },
  data () {
    return {
      src: ""
    }
  },
  mounted () {
    this.src = getFileUrl(this.attrs.host, this.value || this.attrs.src);
  },
  computed: {
    // src () {
    //   return getFileUrl(this.attrs.host, this.value || this.attrs.src);
    // },
    previewSrcList () {
      if (!this.attrs.preview) return [];
      if (this._.isArray(this.columnValue || this.attrs.src)) {
        return this.columnValue.map(item => {
          return getFileUrl(this.attrs.host, item);
        });
      } else {
        return [getFileUrl(this.attrs.host, this.columnValue || this.attrs.src)];
      }
    }
  },
  watch: {
    value () {
      this.src = getFileUrl(this.attrs.host, this.value || this.attrs.src);
    },
    "attrs.src" () {
      this.src = getFileUrl(this.attrs.host, this.value || this.attrs.src);
    }
  }
};
</script>
