import swal from 'sweetalert';

export function useFlash() { 
    function flash(head,msg,type){
        return swal(head,msg,type);
    }

    return { flash };
}