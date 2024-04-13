var Utils = {
  block_ui: function (element) {
    $(element).block({
      message: '<div class="spinner-border text-primary" role="status"></div>',
      css: {
        backgroundColor: "transparent",
        border: "0",
      },
      overlayCSS: {
        backgroundColor: "#000",
        opacity: 0.25,
      },
    });
  },
  unblock_ui: function (element) {
    $(element).unblock({});
  },
  calculateBadges: (score) => {
    let badges = "";
    if (score >= 10) {
      badges += "&#10020; ";
    }
    if (score >= 25) {
      badges += "&#10021; ";
    }
    if (score >= 50) {
      badges += "&#10045; ";
    }
    if (score >= 100) {
      badges += "&#10051; ";
    }
    return badges;
  },
};
