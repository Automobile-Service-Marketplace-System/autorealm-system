const jobCardStatProgresses = document.querySelectorAll('.job-card__stat--progress');

jobCardStatProgresses.forEach((jobCardStatProgress) => {
    const doneAmount = Number.parseInt(jobCardStatProgress.dataset.done);
    const totalAmount = Number.parseInt(jobCardStatProgress.dataset.all);
    console.log(`Ratio = ${doneAmount} / ${totalAmount}`);
})
