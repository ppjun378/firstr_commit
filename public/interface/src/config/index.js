let isDev = () => {
  return process.env.NODE_ENV === 'development'
};

export default {
  isDev: isDev(),
  apiServer: isDev() ? 'http://127.0.0.2/inforward/admin/api/' : 'http://admin.inforward.com.cn/inforward/admin/api/',
  mockOpen: false,
}
