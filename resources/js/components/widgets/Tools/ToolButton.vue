<template>
  <div class="tool-button">
    <el-tooltip
      :content="attrs.tooltip"
      placement="top"
      :disabled="!attrs.tooltip"
    >
      <el-popconfirm
        placement="top"
        :title="attrs.message"
        @confirm="onClick"
        v-if="attrs.message"
      >
        <el-button
          slot="reference"
          :type="attrs.type"
          :size="attrs.size"
          :plain="attrs.plain"
          :round="attrs.round"
          :circle="attrs.circle"
          :disabled="attrs.disabled"
          :icon="attrs.icon"
          :autofocus="attrs.autofocus"
          :loading="loading"
          >{{ attrs.content }}
        </el-button>
      </el-popconfirm>
      <el-button
        v-else
        :type="attrs.type"
        :size="attrs.size"
        :plain="attrs.plain"
        :round="attrs.round"
        :circle="attrs.circle"
        :disabled="attrs.disabled"
        :icon="attrs.icon"
        :autofocus="attrs.autofocus"
        :loading="loading"
        @click="onClick"
        >{{ attrs.content }}
      </el-button>
    </el-tooltip>
    <el-dialog
      v-if="attrs.dialog"
      :title="attrs.dialog.title"
      :visible.sync="dialogTableVisible"
      :width="attrs.dialog.width"
      :fullscreen="attrs.dialog.fullscreen"
      :top="attrs.dialog.top"
      :modal="attrs.dialog.modal"
      :lock-scroll="attrs.dialog.lockScroll"
      :custom-class="attrs.dialog.customClass"
      :show-close="attrs.dialog.showClose"
      :center="attrs.dialog.center"
      :close-on-click-modal="attrs.dialog.closeOnClickModal"
      :close-on-press-escape="attrs.dialog.closeOnPressEscape"
      append-to-body
      destroy-on-close
    >
      <component
        v-if="attrs.dialog.slot"
        :is="attrs.dialog.slot.componentName"
        :attrs="attrs.dialog.slot"
      />
    </el-dialog>
  </div>
</template>
<script>
export default {
  props: {
    attrs: Object,
  },
  data() {
    return {
      loading: false,
      dialogTableVisible: false,
    };
  },
  mounted() {
    this.$bus.on(this.attrs.busClose, (data) => {
      this.dialogTableVisible = false;
    });
  },
  destroyed() {
    this.$bus.off(this.attrs.busClose);
  },
  methods: {
    onClick() {
      if (this.attrs.dialog) {
        this.dialogTableVisible = true;
        return;
      }
      switch (this.attrs.handler) {
        case "route":
          this.$router.push(this.attrs.uri);
          break;
        case "link":
          window.location.href = this.attrs.uri;
          break;
        case "request":
          this.onRequest(this.attrs.uri);
          break;
        default:
          this.$message.warning("响应类型未定义");
          break;
      }
    },
    onRequest(uri) {
      this.loading = true;
      this.beforeEmit();
      this.$http[this.attrs.requestMethod](uri)
        .then((res) => {
          if (res.code == 200) {
            this.successEmit();
          }
        })
        .finally(() => {
          this.loading = false;
          this.afterEmit();
        });
    },
    beforeEmit() {
      this.attrs.beforeEmit.map((item) => {
        this.$bus.emit(item.eventName, item.eventData);
      });
    },
    afterEmit() {
      this.attrs.afterEmit.map((item) => {
        this.$bus.emit(item.eventName, item.eventData);
      });
    },
    successEmit() {
      this.attrs.successEmit.map((item) => {
        this.$bus.emit(item.eventName, item.eventData);
      });
    },
  },
};
</script>
