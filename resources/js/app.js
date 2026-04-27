import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

let pendingForm = null;

const modalIcons = {
    success: `
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
    `,
    danger: `
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78A1.5 1.5 0 0022.18 18L13.71 3.86a1.5 1.5 0 00-2.42 0z" />
            </svg>
        </div>
    `,
    warning: `
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78A1.5 1.5 0 0022.18 18L13.71 3.86a1.5 1.5 0 00-2.42 0z" />
            </svg>
        </div>
    `,
    neutral: `
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 8.25h7.5m-7.5 3.75h7.5m-7.5 3.75h4.5M6 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75z" />
            </svg>
        </div>
    `,
};

function openConfirmModal(options = {}) {
    const modal = document.getElementById("globalConfirmModal");

    if (!modal) {
        return;
    }

    const title = document.getElementById("globalConfirmModalTitle");
    const message = document.getElementById("globalConfirmModalMessage");
    const icon = document.getElementById("globalConfirmModalIcon");
    const confirmButton = document.getElementById(
        "globalConfirmModalConfirmButton",
    );
    const extraContent = document.getElementById(
        "globalConfirmModalExtraContent",
    );

    if (!title || !message || !icon || !confirmButton || !extraContent) {
        return;
    }

    title.textContent = options.title || "Confirm Action";
    message.textContent =
        options.message || "Are you sure you want to continue?";
    confirmButton.textContent = options.confirmText || "Confirm";

    icon.innerHTML = modalIcons[options.iconType || "neutral"];

    confirmButton.className =
        "rounded-lg px-4 py-2 text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2";

    const variantClasses = {
        primary: "bg-[#6B0F1A] hover:bg-[#4A0A12] focus:ring-[#6B0F1A]",
        success: "bg-green-600 hover:bg-green-700 focus:ring-green-600",
        warning: "bg-amber-600 hover:bg-amber-700 focus:ring-amber-600",
        danger: "bg-red-600 hover:bg-red-700 focus:ring-red-600",
        neutral: "bg-gray-700 hover:bg-gray-800 focus:ring-gray-700",
    };

    confirmButton.classList.add(
        ...variantClasses[options.variant || "primary"].split(" "),
    );

    if (options.requireReason) {
        extraContent.classList.remove("hidden");
        extraContent.innerHTML = `
            <label for="modalReasonInput" class="block text-sm font-medium text-gray-700">
                Reason <span class="text-red-600">*</span>
            </label>
            <textarea
                id="modalReasonInput"
                rows="4"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#6B0F1A] focus:ring-[#6B0F1A]"
                placeholder="Enter reason here..."
                required
            ></textarea>
            <p id="modalReasonError" class="mt-2 hidden text-sm text-red-600">
                Please enter a reason before continuing.
            </p>
        `;
    } else {
        extraContent.classList.add("hidden");
        extraContent.innerHTML = "";
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    confirmButton.focus();
}

function closeConfirmModal() {
    const modal = document.getElementById("globalConfirmModal");

    if (!modal) {
        return;
    }

    modal.classList.add("hidden");
    modal.classList.remove("flex");

    pendingForm = null;
}

function createPostFormFromLink(href) {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = href;

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    if (csrfToken) {
        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
    }

    document.body.appendChild(form);

    return form;
}

document.addEventListener("click", function (event) {
    const trigger = event.target.closest("[data-confirm]");

    if (trigger) {
        event.preventDefault();

        pendingForm = trigger.closest("form");

        if (!pendingForm && trigger.getAttribute("href")) {
            pendingForm = createPostFormFromLink(trigger.getAttribute("href"));
        }

        openConfirmModal({
            title: trigger.dataset.confirmTitle,
            message: trigger.dataset.confirmMessage,
            confirmText: trigger.dataset.confirmText,
            variant: trigger.dataset.confirmVariant,
            iconType: trigger.dataset.confirmIcon,
            requireReason: trigger.dataset.confirmRequireReason === "true",
        });

        return;
    }

    const closeButton = event.target.closest("[data-modal-close]");

    if (closeButton) {
        closeConfirmModal();
    }
});

document.addEventListener("click", function (event) {
    if (event.target?.id !== "globalConfirmModalConfirmButton") {
        return;
    }

    if (!pendingForm) {
        closeConfirmModal();
        return;
    }

    const reasonInput = document.getElementById("modalReasonInput");

    if (reasonInput) {
        const reason = reasonInput.value.trim();
        const reasonError = document.getElementById("modalReasonError");

        if (!reason) {
            reasonError.classList.remove("hidden");
            reasonInput.focus();
            return;
        }

        let hiddenReason = pendingForm.querySelector(
            'input[name="admin_note"]',
        );

        if (!hiddenReason) {
            hiddenReason = document.createElement("input");
            hiddenReason.type = "hidden";
            hiddenReason.name = "admin_note";
            pendingForm.appendChild(hiddenReason);
        }

        hiddenReason.value = reason;
    }

    pendingForm.submit();
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeConfirmModal();
    }

    document.addEventListener("click", function (event) {
        const toggleButton = event.target.closest("[data-password-toggle]");

        if (!toggleButton) {
            return;
        }

        const targetId = toggleButton.dataset.passwordTarget;
        const passwordInput = document.getElementById(targetId);

        if (!passwordInput) {
            return;
        }

        const eyeIcon = toggleButton.querySelector(".password-eye");
        const eyeOffIcon = toggleButton.querySelector(".password-eye-off");

        const isHidden = passwordInput.type === "password";

        passwordInput.type = isHidden ? "text" : "password";

        toggleButton.setAttribute(
            "aria-label",
            isHidden ? "Hide password" : "Show password",
        );

        eyeIcon?.classList.toggle("hidden", isHidden);
        eyeOffIcon?.classList.toggle("hidden", !isHidden);
    });
});
