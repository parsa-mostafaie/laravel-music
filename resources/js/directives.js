export const pageDirectives = [
  "is-admin",
  "is-manager",
  (props = null) => (props ? props.auth.user : "only-user"),
  (props = null) => (props ? !!props.auth?.user : "only-guest"),
];
