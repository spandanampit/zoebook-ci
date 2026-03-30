import MovementForm from "./MovementForm";

function AddMovementSection({
    mode = "create",
    initialData = null,
    isPrefillLoading = false,
    prefillError = "",
}) {
    return (
        <div className="w-full max-w-4xl mx-auto">
            <MovementForm
                mode={mode}
                initialData={initialData}
                isPrefillLoading={isPrefillLoading}
                prefillError={prefillError}
            />
        </div>
    );
}

export default AddMovementSection;
