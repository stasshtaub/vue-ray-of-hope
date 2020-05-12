<template>
  <div class="post-image-list">
    <div class="image-row" v-for="(row, i) in rows" :key="i">
      <img
        v-for="(img, i) in row"
        :key="i"
        :src="img.src"
        :style="{width: img.width+'px', height: img.height+'px'}"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "post-image-list",
  props: {
    images: {
      type: Array,
      default: () => []
    }
  },
  data: () => ({
    imagesWithSize: [],
    rows: [],

    maxWidth: 0,
    targetHeight: 350,
    borderOffset: 10,
    processedImages: []
  }),
  methods: {
    initialize() {
      this.processedImages = [];
      this.maxWidth = this.$el.clientWidth;

      this.imagesWithSize.forEach(image => {
        var newImage = {
          width: image.width * (this.targetHeight / image.height),
          height: this.targetHeight,
          src: image.src
        };

        this.processedImages.push(newImage);
      });
      this.draw();
    },
    draw() {
      var rows = this.buildRows();

      rows.forEach(row => {
        this.fitImagesInRow(row);
      });

      this.rows = rows;
    },
    buildRows() {
      var currentRow = 0;
      var currentWidth = 0;
      var imageCounter = 0;
      var rows = [];

      while (this.processedImages[imageCounter]) {
        if (currentWidth >= this.maxWidth) {
          currentRow++;
          currentWidth = 0;
        }
        if (!rows[currentRow]) {
          rows[currentRow] = [];
        }

        rows[currentRow].push(this.processedImages[imageCounter]);
        currentWidth += this.processedImages[imageCounter].width;

        imageCounter++;
      }
      //   if (rows[rows.length - 1].length == 1) {
      //     let lastImage = rows[rows.length - 1][0];
      //     let k = this.maxWidth / lastImage.width;
      //     lastImage.width *= k;
      //     lastImage.height *= k;
      //   }
      return rows;
    },
    fitImagesInRow(images) {
      let totalWidth = this.getCumulativeWidth(images);
      let withoutBorders =
        this.maxWidth - this.borderOffset * (images.length - 1);
      let k = totalWidth / withoutBorders;
      images.forEach(image => {
        image.width /= k;
        image.height /= k;
      });
    },
    getCumulativeWidth(images) {
      var width = 0;
      images.forEach(image => {
        width += image.width;
      });
      return width;
    }
  },
  mounted() {
    this.images.forEach(image => {
      let img = new Image();
      img.onload = () => {
        this.imagesWithSize.push({
          src: img.src,
          width: img.width,
          height: img.height
        });
        if (this.imagesWithSize.length == this.images.length) {
          window.addEventListener("resize", this.initialize);
          this.initialize();
        }
      };
      img.src = image.url;
    });
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.initialize);
  }
};
</script>

<style>
.image-row {
  width: 100%;
  white-space: nowrap;
  line-height: 0;
  margin: 0 -5px;
}

.image-row:not(:last-of-type) {
  margin-bottom: 10px;
}

.image-row img {
  margin: 0 5px;
  border-radius: 10px;
}
</style>