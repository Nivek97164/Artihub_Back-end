// src/utils/logout.ts
export async function logout(router: any) {
  await fetch("https://artihubback-end-production.up.railway.app/auth/logout.php", {
    method: "GET",
    credentials: "include",
  });
  router.push("/espace-pro/login");
}
