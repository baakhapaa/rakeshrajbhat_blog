export default {
  async fetch(request) {
    const incoming = new URL(request.url);

    if (incoming.hostname === "rakeshrajbhat.com" || incoming.hostname === "www.rakeshrajbhat.com") {
      return fetch(request);
    }

    const target = new URL(incoming.pathname + incoming.search, "https://rakeshrajbhat.com");
    return Response.redirect(target.toString(), 302);
  },
};
