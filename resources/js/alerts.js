import Swal from "sweetalert2";

export async function error() {
  return Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: '<a href="#">Why do I have this issue?</a>',
  });
}

export async function dangerWork() {
  return Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Do it!",
  });
}

export async function cancel() {
  return Swal.fire({
    title: "Cancelled",
    text: "Your Work is safe :)",
    icon: "error",
  });
}

export async function success() {
  return Swal.fire({
    icon: "success",
    title: "The action is done",
    showConfirmButton: false,
    timer: 1500,
  });
}
