export const request = async (method, url, data = {}) => {
  try {
    const response = await fetch(url, {
      method,
      headers: {
        "content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]").content,
        // "Content-Type": "application/x-www-form-urlencoded",
      },
      ...(method === "get" ? {} : { body: JSON.stringify(data) })
    });

    if (response.status >= 200 && response.status < 300) {
      return await response.json();
    }
    throw await response.json();
  } catch (error) {
    throw error;
  }
};

export const get = (url) => {
  return request("get", url);
};

export const post = (url, data) => {
  return request("post", url, data);
};
