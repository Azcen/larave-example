// Is there a best way to get Laravel errors message without libs?
const checkResponse = ({ status, data }) => {
  if (status === 404 || status === 400) {
    return {
      message: data.errors[Object.keys(data.errors)].message,
    };
  }
  if ((status < 200 || status >= 300) && data.errors) {
    return {
      message: data.errors[Object.keys(data.errors)[0]][0],
    };
  } else if (status === 403) {
    return {
      message: data.message,
    };
  }
  return false;
};

export default checkResponse;
