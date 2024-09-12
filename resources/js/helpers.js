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

export function $_GET(name) {
  const _urlSearchParams = new URLSearchParams(location.search);
  return _urlSearchParams.get(name);
}

export function $_SET(name, value) {
  const _urlSearchParams = new URLSearchParams(location.search);
  _urlSearchParams.set(name, value);

  if (history.pushState) {
    var newurl =
      window.location.protocol +
      "//" +
      window.location.host +
      window.location.pathname +
      "?" +
      _urlSearchParams;
    window.history.pushState({ path: newurl }, "", newurl);
  }
}

export function except(list, _) {
  const copy = { ...list };

  if (!(_ instanceof Array)) _ = [_];

  _.forEach((exclude) => delete copy[exclude]);

  return copy;
}
