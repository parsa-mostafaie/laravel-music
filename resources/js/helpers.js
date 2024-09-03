export const debounce = (callback, wait) => {
  let timeoutId = null;
  return (...args) => {
    window.clearTimeout(timeoutId);
    timeoutId = window.setTimeout(() => {
      callback(...args);
    }, wait);
  };
};

export const formatDate = function (date) {
  date = new Date(date);
  return date.getMonth() + 1 + "/" + date.getDate() + "/" + date.getFullYear();
};

export const url = (path) => new URL(path, document.baseURI).href;
