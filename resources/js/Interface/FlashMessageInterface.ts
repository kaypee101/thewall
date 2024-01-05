import { ref } from "vue";
import { useToast } from "vue-toastification";
import FlashMessage from "@/Components/FlashMessage.vue";
import { MessageInterface } from "@/Interface/MessageInterface.ts";

export const useFlashMessage = () => {
    const toast = useToast();
    const message = ref({
        avatar: "",
        subject: "",
        details: "",
    });

    const showFlashMessage = (flash: MessageInterface) => {
        message.value = {
            avatar: flash.message?.avatar ?? "",
            subject: flash.message?.subject,
            details: flash.message?.details,
        };

        FlashMessage.props.flash.message = message.value;
        toast.info(FlashMessage, {
            timeout: 2000,
            pauseOnFocusLoss: false,
            pauseOnHover: false,
            draggable: false,
        });
    };

    return { showFlashMessage };
};
