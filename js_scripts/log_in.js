$("document").ready(async function() {
    const thought = await getOneThought("random");
    $("#random_thought").append(createThoughtEle(thought[0], true));
});